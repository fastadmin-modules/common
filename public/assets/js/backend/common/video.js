define(['jquery', 'bootstrap', 'backend', 'table', 'form'], function ($, undefined, Backend, Table, Form) {

    var Controller = {
        index: function () {
            // 初始化表格参数配置
            Table.api.init({
                extend: {
                    index_url : 'common/video/index' + location.search,
                    add_url   : 'common/video/add',
                    edit_url  : 'common/video/edit',
                    del_url   : 'common/video/del',
                    multi_url : 'common/video/multi',
                    import_url: 'common/video/import',
                    table     : 'common_video',
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
                        {field: 'title', title: __('Title'), operate: 'LIKE'},
                        {
                            field       : 'category_id', title: __('分类'), searchList: function (column) {
                                return `<input id="category_id" placeholder="全部" data-source="common/video_category/index" class="category form-control selectpage" name="supplier_id" type="text">`;
                            }, formatter: function (value, row, index) {
                                return row.category ? row.category.name : ''
                            }
                        },
                        {
                            field    : 'image',
                            title    : __('Image'),
                            operate  : false,
                            events   : Table.api.events.image,
                            formatter: Table.api.formatter.image
                        },
                        {
                            field: 'url', title: __('Url'), operate: false, formatter: function (value, row, index) {
                                let url = ''
                                if (row.type == 2) {
                                    url = Config.upload.cdnurl + value;
                                } else {
                                    url = value;
                                }
                                return '<a href="' + url + '" target="_blank" class="btn btn-default btn-xs"><i class="fa fa-link"></i></a>';
                            }
                        },
                        {field: 'view_num', title: __('View_num')},
                        {field: 'intro', title: __('Intro'), operate: 'LIKE'},
                        {
                            field     : 'status', title: __('Status'),
                            searchList: {"1": __('开启'), "0": __('禁用')},
                            yes       : 1,
                            no        : 0,
                            formatter : Table.api.formatter.toggle
                        },
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
        add  : function () {
            //绑定事件
            $('input[name="row[type]').on('click', function () {
                let ok = $(this).val();
                if (ok == 1) {
                    $('#tag_box1').show();
                    $('#tag_box2').hide();
                } else {
                    $('#tag_box1').hide();
                    $('#tag_box2').show();
                }
            });

            Controller.api.bindevent();
        },
        edit : function () {
            //绑定事件
            $('input[name="row[type]').on('click', function () {
                let ok = $(this).val();
                if (ok == 1) {
                    $('#tag_box1').show();
                    $('#tag_box2').hide();
                } else {
                    $('#tag_box1').hide();
                    $('#tag_box2').show();
                }
            });
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
