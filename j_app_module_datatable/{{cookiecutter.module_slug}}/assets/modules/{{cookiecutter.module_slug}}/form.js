$(document).ready(function() {
    {% for field, details in cookiecutter.fields.items() %} {% if details.meta.form_fillable == "True" %}
        $("#{{field}}").on('change', function(e){
            app.changeInfo("{{ field }}", $(this).val());
        });
    {% endif %}{% endfor %}

});


const __info_form_defaults = {
    {% for field, details in cookiecutter.fields.items() %} {% if details.meta.form_fillable == "True" %}
        {{ field }}: null,
    {% endif %} {% endfor %}
}

var app = new Vue({
    el: '#{{ cookiecutter.module }}_app',
    data: {
        object_request_id: null,
        object_status: 1,

        info: {
            form: {},
            required: {
                {% for field, details in cookiecutter.fields.items() %} {% if details.meta.form_fillable == "True" %}
                    {{ field }}: "{{ details.meta.label }}",
                {% endif %} {% endfor %}
            },
            check: {
                is_valid: false,
                missing_fields: []
            },
            is_active: false,
        },
        items: {
            form: [],
            data: [],
            selected: null,
            selected_idx: null,
            required: {},
            check: {
                is_valid: false,
            },
            deleted_items: [],
            loading: false
        },
        sources: {}
    },
    watch: {

    },
    methods: {

        initObjectRequest() {
            this.object_request_id = window.object_request_id;
            this.object_status = window.object_status;
            this.object_is_editable = window.is_editable;

            if (window.po) {
                this.fetchPO(window.po);
            }

            this.fetchObjectRequest();
        },

        resetItemForm() {
            this.items.selected = null;
            this.items.selected_idx = null;
            this.items.loaded = null;
            this.items.form = {};
        },

        checkItemsForm() {
            this.items.check.is_valid = true;
            if (this.items.data.length <= 0) {
                this.items.check.is_valid = false;
            }
        },

        prepItemsFormData() {
            return this.items.data;
        },

        changeInfo(key, val) {
            this.info.form[key] = val;
        },

        prepInfoFormData() {
            return this.info.form;
        },

        checkInfoForm() {
            this.info.check.missing_fields = [];
            this.info.check.is_valid = true;
            for (var key in this.info.required) {
                if (this.info.form[key] === null) {
                    this.info.check.missing_fields.push(this.info.required[key]);
                    this.info.check.is_valid = false;
                }
            }
        },

        submitRequest() {
            this.checkInfoForm();
            let message = '';
            if (!this.info.check.is_valid) {
                ``
                message = 'Missing fields: ' + this.info.check.missing_fields.join(', ');
                swal.fire({
                    title: "Oooops!",
                    text: message,
                    type: "error",
                });
                return false;
            }

            this.checkItemsForm();
            if (!this.items.check.is_valid) {
                message = 'Please add Canvass items';
                swal.fire({
                    title: "Oooops!",
                    text: message,
                    type: "error",
                });
                return false;
            }

            let url = base_url + "{{ cookiecutter.module }}/process_create";
            if (this.object_request_id) {
                url = base_url + "{{ cookiecutter.module }}/process_update/" + this.object_request_id;
            }

            let data = {
                request: this.prepInfoFormData(),
                items: this.prepItemsFormData(),
                deleted_items: this.items.deleted_items
            }

            $.ajax({
                url: url,
                type: 'POST',
                dataType: 'JSON',
                data: data,
                success: function(response) {
                    if (response.status) {
                        swal.fire({
                            title: "Success!",
                            text: response.message,
                            type: "success",
                        }).then(function() {
                            window.location.replace(
                                base_url + "{{ cookiecutter.module }}"
                            );
                        });
                    }
                }
            })

        },

        fetchObjects(table, lookup_field) {
            let url = base_url + "generic_api/fetch_all?table=" + table;
            axios.get(url)
                .then(response => {
                    if (response.data) {
                        this.sources[table] = response.data;
                    } else {
                        this.sources[table] = [];
                    }
                })
        },

        fetchObjectRequest() {
            if (this.object_request_id) {
                let url = base_url + "{{ cookiecutter.module }}/search?id=" + this.object_request_id + "&with_relations=no";
                axios.get(url)
                    .then(response => {
                        if (response.data) {
                            this.parseObjectRequest(response.data);
                        }
                    });
            } else {
                this.info.form = JSON.parse(JSON.stringify(__info_form_defaults));
            }

        },
        fetchObjectRequestChildren() {
            let url = base_url + "{{ cookiecutter.module }}_item/get_all_by_parent/" + this.object_request_id;
            axios.get(url)
                .then(response => {
                    if (response.data) {
                        this.parseObjectRequestItems(response.data);
                    }
                });
        },
        parseObjectRequest(data) {
            if (data.length > 0) {
                this.info.form = data[0];
                this.fetchObjectRequestChildren();
            }
        },

        parseObjectRequestItems(data) {
            for (row in data) {
                this.addItemToCart(false, data[row]);
            }
        },

        addItemToCart(isNew, data) {
            let item = {};

            if (isNew) {
                for (key in data) {
                    item[key] = data[key];
                }
                // do something with id
                // delete item['id'];
                delete item['created_by'];
                delete item['created_at'];
                delete item['updated_at'];
                delete item['updated_by'];
                delete item['deleted_by'];
                delete item['deleted_at'];

            } else {
                for (key in data) {
                    item[key] = data[key];
                }
            }

            if (item.id) {
                let idx = this.searchItemInStore(item.id);
                if (idx !== null) {
                    this.items.data[idx] = item;
                } else {
                    this.items.data.push(item);
                }
            } else {
                this.items.data.push(item);
            }
            this.$forceUpdate();

            this.resetItemForm();
        },

        searchItemInStore(id) {
            for (let i = 0; i < this.items.data.length; i++) {
                if (id == this.items.data[i].id) {
                    return i;
                }
            }
            return null;
        },

    },
    mounted() {

        this.initObjectRequest();

        this.is_mounted = true;
        this.object_request_id = window.object_request_id;


    }
});