ajax_options = {type: 'GET', data:{},dataType: 'json',error: function(XMLHttpRequest, textStatus, errorThrown) {
    alert('Ошибка');
}}
stateSearchParams = '';

id_demand = 0;
open_demand = 0;
id_group = 0;
gpage = 0;
demand_url = "/demands/";
dialog_state = null;
demand_height = 870;


icons = {};

function destroy_dialog(event, ui) {
    //$('#catalog_place').html('&nbsp;');
    $('#dialog_object').hide();
    $('#dialog_object').dialog('destroy');
}
function destroy_dialog2(event, ui) {
    //$('#catalog_place').html('&nbsp;');
    $('#dialog_object2').hide();
    $('#dialog_object2').dialog('destroy');
}
function change_demand_grid(id) {
    var row = $.fn.yiiGridView.getSelection(id);
    if (!isNaN(parseInt(row))) id_demand = parseInt(row);
    edit_demand(id_demand);
}

function edit_demand(id_demand) {
    var dial_param = {
        modal:true,
        width:'650px',
        height:'300',
        position:["top",50],
        close: destroy_dialog2
    };
    var options = ajax_options;
    options['dataType'] = 'html';
    options['type'] = 'GET';
    options['data']={id:id_demand};
    options['url'] = '/demands/update';
    options['success'] = function(result, status) {
        var res_str = '';
        $('#dialog_object2').attr('title', 'Редактирование заказа');
        $('#dialog_object2').html(result);
        $('#dialog_object2').dialog(dial_param);
        $('#subDemandBtn').bind('click',save_demand);
    }
    $.ajax(options);
}

function save_demand() {
    var param = $('#demand-form').serialize();
    var options = ajax_options;
    options['dataType'] = 'html';
    options['type'] = 'POST';
    options['data'] = param;
    options['url'] = $('#demand-form').attr('action');
    options['success'] = function(result, status) {
        if (result == '1') {
            alert("Изменения успешно внесены");
            location.reload();
        } else $('#dialog_object2').html(result);

    }
    $.ajax(options);
    options['type'] = 'GET';
    return false;
}