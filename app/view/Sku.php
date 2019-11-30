<?php

namespace app\view;

use framework\base\bView;

class Sku extends bView
{
    public function __construct()
    {
    }

    public function render()
    {
        ?>
        <html>
        <head>
            <title>SKU</title>
            <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" rel="stylesheet"
                  integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh"
                  crossorigin="anonymous">
        </head>
        <body>
        <div class="row">
            <div class="modal fade" id="staticBackdrop" data-backdrop="static" tabindex="-1" role="dialog"
                 aria-labelledby="staticBackdropLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="staticBackdropLabel">New/Edit SKU</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form id="create-edit-sku-form">
                                <input type="hidden" value="" id="pk-sku" name="pk-sku">
                                <div class="form-group row">
                                    <label for="sku" class="col-sm-2 col-form-label">SKU</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" id="sku" name="sku">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="description" class="col-sm-2 col-form-label">Description</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" id="description" name="description">
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-primary" id="submit-create-edit-sku">
                                <span class="spinner-border spinner-border-sm" id="form-loader" role="status"
                                      aria-hidden="true"></span>
                                Save
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="container">
            <div class="row">
                <div class="col-sm">
                    <h1>SKU</h1>
                </div>
            </div>

            <div class="row">
                <div class="col-md">
                    <table class="table" id="skus">
                        <thead>
                        <tr>
                            <td colspan="5">
                                <button id="create-sku" type="button" class="btn btn-primary" data-toggle="modal"
                                        data-target="#staticBackdrop">New SKU ...
                                </button>
                                <button id="reload-sku" type="button" class="btn btn-secondary">Reload</button>
                            </td>
                            <td>
                                <div class="spinner-border" id="table-loader" role="status">
                                    <span class="sr-only">Loading...</span>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>PK</td>
                            <td>SKU</td>
                            <td>Description</td>
                            <td>Created At</td>
                            <td>Updated At</td>
                            <td></td>
                        </tr>
                        </thead>
                        <tbody></tbody>
                        <tfoot>
                        <tr>
                            <td colspan="6">
                                <nav aria-label="Navigation">
                                    <ul id="sku-pagination" class="pagination">
                                    </ul>
                                </nav>
                            </td>
                        </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>

        </body>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"
                integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo"
                crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.bundle.min.js"
                integrity="sha384-6khuMg9gaYr5AxOqhkVIODVIvm9ynTT5J4V1cfthmT+emCG6yVmEZsRHdxlotUnm"
                crossorigin="anonymous"></script>
        <script src="/assets/sku.js"></script>
        <script>
            const routes = {
                list: "/sku/list",
                create: "/sku/create",
                edit: "/sku/edit"
            };
        </script>
        </html>
        <?php
    }
}
