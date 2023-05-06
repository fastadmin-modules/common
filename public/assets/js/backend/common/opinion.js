define(['jquery', 'bootstrap', 'backend', 'table', 'form'], function ($, undefined, Backend, Table, Form) {

    return {
        index: function () {
            // 初始化表格参数配置
            Table.api.init({
                extend: {
                    index_url: 'common/opinion/index' + location.search,
                    del_url  : 'common/opinion/del',
                    table    : 'common_opinion',
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
                        {field: 'id', title: __('Id')},
                        {field: 'user_id', title: __('User_id'), visible: false},
                        {
                            field    : 'user.avatar',
                            title    : __('User.avatar'),
                            operate  : 'LIKE',
                            events   : Table.api.events.image,
                            formatter: Table.api.formatter.image
                        },
                        {field: 'user.nickname', title: __('User.nickname'), operate: 'LIKE'},
                        {field: 'user.mobile', title: __('User.mobile'), operate: 'LIKE', visible: false},
                        {
                            field    : 'images',
                            title    : __('Images'),
                            operate  : false,
                            events   : Table.api.events.image,
                            formatter: Table.api.formatter.images
                        },
                        {field: 'content', title: __('Content'), operate: 'LIKE', width: '300px', cellStyle: function () {return {css: {"text-align": "left !important", "white-space": "normal"}};}},
                        {
                            field       : 'create_time',
                            title       : __('Create_time'),
                            operate     : 'RANGE',
                            addclass    : 'datetimerange',
                            autocomplete: false,
                            formatter   : Table.api.formatter.datetime
                        },
                        {
                            field    : 'operate',
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
        api  : {
            bindevent: function () {
                Form.api.bindevent($("form[role=form]"));
            }
        }
    };
});