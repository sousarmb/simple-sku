$(function () {
    $("#form-loader").hide();

    $("#reload-sku").on("click", function () {
        getAllSku();
    }).click();

    $("#create-sku").on("click", function () {
        $("#create-edit-sku-form").data("action", "create");
        $("#pk-sku, #sku, #description").val("");
    });

    $(document).on('click', 'button.edit-sku', function () {
        $("#create-edit-sku-form").data("action", "edit");
        $("#pk-sku").val($(this).data("pk"));
        $("#sku").val($(this).parent().prev().prev().prev().prev().text());
        $("#description").val($(this).parent().prev().prev().prev().text());
    });

    $("#submit-create-edit-sku").on('click', function () {
        const p = {
            pk: parseInt($("#pk-sku").val()),
            sku: $("#sku").val(),
            description: $("#description").val()
        };
        let route;
        if ($("#create-edit-sku-form").data("action") === "create") {
            route = routes.create;
        } else {
            route = routes.edit;
        }
        $("#form-loader").show();
        $.post(route, JSON.stringify(p), function (data) {
            if (data.err.length) {
                alert("Error: " + data.err.join(", "));
            } else {
                $("#staticBackdrop").modal("hide");
                getAllSku();
            }
        }).fail(function () {
            alert("Failed to create/edit SKU");
        }).always(function () {
            $("#form-loader").hide();
        });
    });

});

function getAllSku(page) {
    $("#table-loader").show();
    var route = routes.list;

    if (typeof page !== "undefined") {
        route = route + "?page=" + page;
    }

    $.getJSON(route, function (data) {
        const tbody = $("#skus > tbody").empty();

        $.each(data[0], function (k, v) {
            var row = $("<tr>");
            for (var i = 0; i < 6; i++) {
                row.append("<td>");
            }

            row.find("td:nth-child(1)").text(v[0]);
            row.find("td:nth-child(2)").text(v[1]);
            row.find("td:nth-child(3)").text(v[2]);
            row.find("td:nth-child(4)").text(v[3]);
            row.find("td:nth-child(5)").text(v[4]);

            const btn_edit = $("<button>").attr("type", "button")
                .addClass("btn btn-primary edit-sku")
                .attr("data-toggle", "modal")
                .attr("data-target", "#staticBackdrop")
                .data("pk", v[0])
                .html("Edit ...");
            row.find("td:nth-child(6)").append(btn_edit);
            tbody.append(row);
        });

        var pages = $("#sku-pagination").empty();
        for (var i = 0; i < data[2]; i++) {

            var pg_li = $("<li>").addClass("page-item");
            var li_a = $("<a>").addClass("page-link")
                .attr("href", "#")
                .on("click", {page: i}, function (evt) {
                    getAllSku(evt.data.page);
                })
                .text(i + 1);
            if (data[1] === i) {
                pg_li.addClass("active");
            }

            pg_li.append(li_a);
            pages.append(pg_li);
        }
    }).fail(function () {
        $("#skus > tbody").empty();
        alert("Data load failed!");
    }).always(function () {
        $("#table-loader").hide();
    })
}
