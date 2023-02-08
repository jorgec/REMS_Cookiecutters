# CodeIgniter Cookiecutters
Fast scaffolding for codeigniter projects

## Installation
1. Create a Python environment (req. 3.8+)
-- https://docs.python.org/3/library/venv.html
2. Install dependencies
`pip install -r requirements.txt`
3. Profit

## base_module

`cookiecutter base_module`

### Fields setup
Using Suggests

    "field": {
            "db": {
                "type": "INT",
                "constraint": "11",
                "unsigned": "True",
                "auto_increment": "False",
                "NOT NULL": "True"
            },
            "meta": {
                "form_updateable":"True",
                "form_fillable": "True",
                "label": "Transaction",
                "rules": "required|numeric",
                "is_one": "True",
                "is_many": "False",
                "module": "transaction",
                "model": "Transaction_model",
                "table": "transactions",
                "key": "transaction_id",
                "fk": "id",
                "form_elem": "suggests"
            }
        }

Using Dropdown.php

    "field" : {
            "db": {
                "type": "INT",
                "constraint": "1",
                "unsigned": "True"
            },
            "meta": {
                "form_fillable": "True",
                "form_updateable": "True",
                "label": "Cancellation Status",
                "rules": null,
                "is_one": "False",
                "is_many": "False",
                "module": null,
                "model": null,
                "table": null,
                "key": null,
                "fk": null,
                "form_elem": "static_dropdown",
                "static_dropdown":"cancellation_queue_status"
            }
    },
