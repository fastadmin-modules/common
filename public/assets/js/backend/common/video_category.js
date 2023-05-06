define(['jquery', 'bootstrap', 'backend', 'table', 'form'], function ($, undefined, Backend, Table, Form) {

    var Controller = {
        index: function () {
            // 初始化表格参数配置
            Table.api.init({
                extend: {
                    index_url : 'common/video_category/index' + location.search,
                    add_url   : 'common/video_category/add',
                    edit_url  : 'common/video_category/edit',
                    del_url   : 'common/video_category/del',
                    multi_url : 'common/video_category/multi',
                    import_url: 'common/video_category/import',
                    table     : 'common_video_category',
                }
            });

            var table = $("#table");

            // 初始化表格
            table.bootstrapTable({
                url     : $.fn.bootstrapTable.defaults.extend.index_url,
                pk      : 'id',
                sortName: 'id',
                columns : [
                    [
                        {checkbox: true},
                        {field: 'name', title: __('Name'), operate: 'LIKE'},
                        {field: 'desc', title: __('介绍'), operate: 'LIKE'},
                        {
                            field     : 'status', title: __('Status'),
                            searchList: {"1": __('开启'), "0": __('禁用')},
                            yes       : 1,
                            no        : 0,
                            formatter : Table.api.formatter.toggle
                        },
                        {field          : 'create_time',
                            title       : __('Create_time'),
                            operate     : 'RANGE',
                            addclass    : 'datetimerange',
                            autocomplete: false,
                            formatter   : Table.api.formatter.datetime
                        },
                        {field       : 'operate',
                            title    : __('Operate'),
                            table    : table,
                            events   : Table.api.events.operate,
                            formatter: Table.api.formatter.operate
                        }
                    ]
                ]
            });

            // 为表格绑定事件
            Table.api.bindevent(table);
        },
        add  : function () {
            Controller.api.bindevent();
        },
        edit : function () {
            Controller.api.bindevent();
        },
        api  : {
            bindevent: function () {
                Form.api.bindevent($("form[role=form]"));
            }
        }
    };
    return Controller;
});
