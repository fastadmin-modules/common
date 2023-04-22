define(['jquery', 'bootstrap', 'backend', 'table', 'form'], function ($, undefined, Backend, Table, Form) {

    var Controller = {
        index: function () {
            // 初始化表格参数配置
            Table.api.init({
                extend: {
                    index_url: 'common/slide/index' + location.search,
                    add_url: 'common/slide/add',
                    edit_url: 'common/slide/edit',
                    del_url: 'common/slide/del',
                    multi_url: 'common/slide/multi',
                    import_url: 'common/slide/import',
                    table: 'common_slide',
                }
            });

            var table = $("#table");

            // 初始化表格
            table.bootstrapTable({
                url: $.fn.bootstrapTable.defaults.extend.index_url,
                pk: 'id',
                sortName: 'weigh',
                columns: [
                    [
                        {checkbox: true},
                        {field: 'id', title: __('Id'), sortable: true},
                        {field: 'title', title: __('Title'), operate: 'LIKE'},
                        {field: 'image', title: __('Image'), operate: false, events: Table.api.events.image, formatter: Table.api.formatter.image},
                        {field: 'link', title: __('Link'), operate: 'LIKE'},
                        {field: 'status', title: __('Status'), table: table, formatter: Table.api.formatter.toggle, searchList: {1: __('Status 1'), 2: __('Status 2')}},
                        {field: 'weigh', title: __('Weigh'), sortable: true, operate: false},
                        {field: 'create_time', title: __('Create_time'), sortable: true, operate:'RANGE', addclass:'datetimerange', autocomplete:false, formatter: Table.api.formatter.datetime},
                        {field: 'operate', title: __('Operate'), table: table, events: Table.api.events.operate, formatter: Table.api.formatter.operate}
                    ]
                ]
            });

            // 为表格绑定事件
            Table.api.bindevent(table);
        },
        add: function () {
            Controller.api.bindevent();
        },
        edit: function () {
            Controller.api.bindevent();
        },
        api: {
            bindevent: function () {
                Form.api.bindevent($("form[role=form]"));
            }
        }
    };
    return Controller;
});