@extends('layouts.admin')
@section('style')
    <link rel="stylesheet" href="{{asset('assets/css/jquery-ui.custom.min.css')}}"/>
    <link rel="stylesheet" href="{{asset('assets/css/chosen.min.css')}}"/>
    <link rel="stylesheet" href="{{asset('assets/css/bootstrap-datepicker3.min.css')}}"/>
    <link rel="stylesheet" href="{{asset('assets/css/bootstrap-timepicker.min.css')}}"/>
    <link rel="stylesheet" href="{{asset('assets/css/daterangepicker.min.css')}}"/>
    <link rel="stylesheet" href="{{asset('assets/css/bootstrap-datetimepicker.min.css')}}"/>
    <link rel="stylesheet" href="{{asset('assets/css/bootstrap-colorpicker.min.css')}}"/>
@endsection
@section('breadcrumb')
    <div class="row">
        <div class="col-sm-4" style="text-align: left; padding-left: 32px">
            <a href="{{route('books.create')}}">
                <button type="button" class="btn btn-success btn-sm">Add new books</button>
            </a>
        </div>
        <div class="nav-search col-sm-4" id="nav-search" style="text-align: right">
            <form class="form-search" action="{{route('books.search')}}" method="post">
                @csrf
								<span class="input-icon">
									<input name="search" type="text" placeholder="Search ..." class="nav-search-input"
                                           id="nav-search-input" autocomplete="off"/>
									<i class="ace-icon fa fa-search nav-search-icon"></i>
								</span>
            </form>
        </div>
    </div>
@endsection
@section('content')
    {{--
        <a href="#modal-form" role="button" class="blue" data-toggle="modal"> Form Inside a Modal Box </a>
    --}}
    <table id="simple-table" class="table  table-bordered table-hover">
        <thead>
        <tr>
            <th class="center">
                <i class="ace-icon fa fa-list bigger-110 hidden-480"></i>
            </th>
            <th class="center">
                <i class="ace-icon fa fa-photo bigger-110 hidden-480"></i>
                Avatar
            </th>
            <th class="center">
                <i class="ace-icon fa fa-user bigger-110 hidden-480"></i>
                Name
            </th>
            <th class="center">
                <i class="ace-icon fa fa-calendar bigger-110 hidden-480"></i>
                Date of Birth
            </th>
            <th class="center">
                <i class="ace-icon fa fa-amazon bigger-110 hidden-480"></i>
                Books in store
            </th>
            <th class="center">
                <i class="ace-icon fa fa-flag bigger-110 hidden-480"></i>
                Country
            </th>

            <th></th>
        </tr>
        </thead>

        <tbody>
        @foreach($books as $key=>$author)
            <tr>
                <td class="center">{{$key +1}}</td>
                <td class="center"><img src="{{asset('storage/'.$author->avatar)}}" height="50px"></td>
                <td class="center" style="padding-top: 20px"><a href="{{$author->wiki_link}}" id="authorName">{{$author->name}}</a></td>
                <td class="center" style="padding-top: 20px">{{$author->born}}</td>
                <td class="center" style="padding-top: 20px">{{$author->book_qty}}</td>
                <td class="center" style="padding-top: 20px">{{$author->country}}</td>
                <td class="center" style="padding-top: 20px">
                    <div class="hidden-sm hidden-xs btn-group">

                        <a class="btn btn-xs btn-info" href="{{route('books.edit',$author->id)}}"><i
                            class="ace-icon fa fa-pencil bigger-120"></i></a>
                        <a class="btn btn-xs btn-danger delete-btn" href="{{route('books.delete',$author->id)}}"><i
                                class="ace-icon fa fa-trash bigger-120"></i></a>

                    </div>

                    <div class="hidden-md hidden-lg">
                        <div class="inline pos-rel">
                            <button class="btn btn-minier btn-primary dropdown-toggle" data-toggle="dropdown"
                                    data-position="auto">
                                <i class="ace-icon fa fa-cog icon-only bigger-110"></i>
                            </button>

                            <ul class="dropdown-menu dropdown-only-icon dropdown-yellow dropdown-menu-right dropdown-caret dropdown-close">
                                <li>
                                    <a href="#" class="tooltip-info" data-rel="tooltip" title="View">
																			<span class="blue">
																				<i class="ace-icon fa fa-search-plus bigger-120"></i>
																			</span>
                                    </a>
                                </li>

                                <li>
                                    <a href="#" class="tooltip-success" data-rel="tooltip" title="Edit">
																			<span class="green">
																				<i class="ace-icon fa fa-pencil-square-o bigger-120"></i>
																			</span>
                                    </a>
                                </li>

                                <li>
                                    <a href="#" class="tooltip-error"  data-rel="tooltip" title="Delete">
																			<span class="red">
																				<i class="ace-icon fa fa-trash-o bigger-120"></i>
																			</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>


    {{--create modal--}}
    <div id="modal-form" class="modal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="blue bigger">Please fill the following form fields</h4>
                </div>
                <form action="{{route('books.store')}}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">

                        <div class="row">
                            <div class="col-xs-12 col-sm-5">
                                <div class="space"></div>
                                <input name="avatar" type="file"/>
                            </div>

                            <div class="col-xs-12 col-sm-7">
                                <div class="space-4"></div>
                                <div class="form-group">
                                    <label for="name">Author's Name</label>
                                    <div>
                                        <input class="col-sm-12" name="name" type="text" id="name"/>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-8">
                                            <label for="country">Country</label>
                                            <div>
                                                <input class="col-sm-12" name="country" type="text"
                                                       id="country"/>
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <label for="book_qty">Book Qty</label>
                                            <div>
                                                <input class="col-sm-12" name="book_qty" type="text"
                                                       id="book_qty" value="0"/>
                                            </div>
                                        </div>
                                    </div>
                                    <label for="wiki_link">Wikipedia</label>
                                    <div>
                                        <input class="col-sm-12" name="wiki_link" type="text" id="wiki_link"/>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <label for="born">Born</label>
                                            <div class="row">
                                                <div class="col-xs-8 col-sm-12">
                                                    <div class="input-group">
                                                        <input name="born" class="form-control date-picker"
                                                               id="born"
                                                               type="text" data-date-format="dd-mm-yy"/>
                                                        <span class="input-group-addon">
																		<i class="fa fa-calendar bigger-110"></i>
																	</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <label for="die">Die</label>
                                            <div class="row">
                                                <div class="col-xs-8 col-sm-12">
                                                    <div class="input-group">
                                                        <input name="die" class="form-control date-picker"
                                                               id="die"
                                                               type="text" data-date-format="dd-mm-yy"/>
                                                        <span class="input-group-addon">
																		<i class="fa fa-calendar bigger-110"></i>
																	</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                                <div class="space-4"></div>
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-sm" data-dismiss="modal">
                            <i class="ace-icon fa fa-times"></i>
                            Cancel
                        </button>

                        <button id="ajaxSubmit" type="button" class="btn btn-sm btn-primary">
                            <i class="ace-icon fa fa-check"></i>
                            Save
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    {{--end create modal--}}
@endsection
@section('script')
    {{--js for this page--}}
    <script src="{{asset('assets/js/chosen.jquery.min.js')}}"></script>
    <script src="{{asset('assets/js/spinbox.min.js')}}"></script>
    <script src="{{asset('assets/js/bootstrap-datepicker.min.js')}}"></script>
    <script src="{{asset('assets/js/bootstrap-timepicker.min.js')}}"></script>
    <script src="{{asset('assets/js/moment.min.js')}}"></script>
    <script src="{{asset('assets/js/daterangepicker.min.js')}}"></script>
    <script src="{{asset('assets/js/bootstrap-datetimepicker.min.js')}}"></script>
    <script src="{{asset('assets/js/bootstrap-colorpicker.min.js')}}"></script>
    <script src="{{asset('assets/js/jquery.knob.min.js')}}"></script>
    <script src="{{asset('assets/js/autosize.min.js')}}"></script>
    <script src="{{asset('assets/js/jquery.inputlimiter.min.js')}}"></script>
    <script src="{{asset('assets/js/jquery.maskedinput.min.js')}}"></script>
    <script src="{{asset('assets/js/bootstrap-tag.min.js')}}"></script>
    <script type="text/javascript">
        jQuery(function ($) {
            $('#id-disable-check').on('click', function () {
                var inp = $('#form-input-readonly').get(0);
                if (inp.hasAttribute('disabled')) {
                    inp.setAttribute('readonly', 'true');
                    inp.removeAttribute('disabled');
                    inp.value = "This text field is readonly!";
                } else {
                    inp.setAttribute('disabled', 'disabled');
                    inp.removeAttribute('readonly');
                    inp.value = "This text field is disabled!";
                }
            });


            if (!ace.vars['touch']) {
                $('.chosen-select').chosen({allow_single_deselect: true});
                //resize the chosen on window resize

                $(window)
                    .off('resize.chosen')
                    .on('resize.chosen', function () {
                        $('.chosen-select').each(function () {
                            var $this = $(this);
                            $this.next().css({'width': $this.parent().width()});
                        })
                    }).trigger('resize.chosen');
                //resize chosen on sidebar collapse/expand
                $(document).on('settings.ace.chosen', function (e, event_name, event_val) {
                    if (event_name != 'sidebar_collapsed') return;
                    $('.chosen-select').each(function () {
                        var $this = $(this);
                        $this.next().css({'width': $this.parent().width()});
                    })
                });


                $('#chosen-multiple-style .btn').on('click', function (e) {
                    var target = $(this).find('input[type=radio]');
                    var which = parseInt(target.val());
                    if (which == 2) $('#form-field-select-4').addClass('tag-input-style');
                    else $('#form-field-select-4').removeClass('tag-input-style');
                });
            }


            $('[data-rel=tooltip]').tooltip({container: 'body'});
            $('[data-rel=popover]').popover({container: 'body'});

            autosize($('textarea[class*=autosize]'));

            $('textarea.limited').inputlimiter({
                remText: '%n character%s remaining...',
                limitText: 'max allowed : %n.'
            });

            $.mask.definitions['~'] = '[+-]';
            $('.input-mask-date').mask('99/99/9999');
            $('.input-mask-phone').mask('(999) 999-9999');
            $('.input-mask-eyescript').mask('~9.99 ~9.99 999');
            $(".input-mask-product").mask("a*-999-a999", {
                placeholder: " ", completed: function () {
                    alert("You typed the following: " + this.val());
                }
            });


            $("#input-size-slider").css('width', '200px').slider({
                value: 1,
                range: "min",
                min: 1,
                max: 8,
                step: 1,
                slide: function (event, ui) {
                    var sizing = ['', 'input-sm', 'input-lg', 'input-mini', 'input-small', 'input-medium', 'input-large', 'input-xlarge', 'input-xxlarge'];
                    var val = parseInt(ui.value);
                    $('#form-field-4').attr('class', sizing[val]).attr('placeholder', '.' + sizing[val]);
                }
            });

            $("#input-span-slider").slider({
                value: 1,
                range: "min",
                min: 1,
                max: 12,
                step: 1,
                slide: function (event, ui) {
                    var val = parseInt(ui.value);
                    $('#form-field-5').attr('class', 'col-xs-' + val).val('.col-xs-' + val);
                }
            });


            //"jQuery UI Slider"
            //range slider tooltip example
            $("#slider-range").css('height', '200px').slider({
                orientation: "vertical",
                range: true,
                min: 0,
                max: 100,
                values: [17, 67],
                slide: function (event, ui) {
                    var val = ui.values[$(ui.handle).index() - 1] + "";

                    if (!ui.handle.firstChild) {
                        $("<div class='tooltip right in' style='display:none;left:16px;top:-6px;'><div class='tooltip-arrow'></div><div class='tooltip-inner'></div></div>")
                            .prependTo(ui.handle);
                    }
                    $(ui.handle.firstChild).show().children().eq(1).text(val);
                }
            }).find('span.ui-slider-handle').on('blur', function () {
                $(this.firstChild).hide();
            });


            $("#slider-range-max").slider({
                range: "max",
                min: 1,
                max: 10,
                value: 2
            });

            $("#slider-eq > span").css({width: '90%', 'float': 'left', margin: '15px'}).each(function () {
                // read initial values from markup and remove that
                var value = parseInt($(this).text(), 10);
                $(this).empty().slider({
                    value: value,
                    range: "min",
                    animate: true

                });
            });

            $("#slider-eq > span.ui-slider-purple").slider('disable');//disable third item


            $('#id-input-file-1 , #id-input-file-2').ace_file_input({
                no_file: 'No File ...',
                btn_choose: 'Choose',
                btn_change: 'Change',
                droppable: false,
                onchange: null,
                thumbnail: false //| true | large
                //whitelist:'gif|png|jpg|jpeg'
                //blacklist:'exe|php'
                //onchange:''
                //
            });
            //pre-show a file name, for example a previously selected file
            //$('#id-input-file-1').ace_file_input('show_file_list', ['myfile.txt'])


            $('#id-input-file-3').ace_file_input({
                style: 'well',
                btn_choose: 'Drop files here or click to choose',
                btn_change: null,
                no_icon: 'ace-icon fa fa-cloud-upload',
                droppable: true,
                thumbnail: 'small'//large | fit
                //,icon_remove:null//set null, to hide remove/reset button
                /**,before_change:function(files, dropped) {
						//Check an example below
						//or examples/file-upload.html
						return true;
					}*/
                /**,before_remove : function() {
						return true;
					}*/
                ,
                preview_error: function (filename, error_code) {
                    //name of the file that failed
                    //error_code values
                    //1 = 'FILE_LOAD_FAILED',
                    //2 = 'IMAGE_LOAD_FAILED',
                    //3 = 'THUMBNAIL_FAILED'
                    //alert(error_code);
                }

            }).on('change', function () {
                //console.log($(this).data('ace_input_files'));
                //console.log($(this).data('ace_input_method'));
            });


            //$('#id-input-file-3')
            //.ace_file_input('show_file_list', [
            //{type: 'image', name: 'name of image', path: 'http://path/to/image/for/preview'},
            //{type: 'file', name: 'hello.txt'}
            //]);


            //dynamically change allowed formats by changing allowExt && allowMime function
            $('#id-file-format').removeAttr('checked').on('change', function () {
                var whitelist_ext, whitelist_mime;
                var btn_choose
                var no_icon
                if (this.checked) {
                    btn_choose = "Drop images here or click to choose";
                    no_icon = "ace-icon fa fa-picture-o";

                    whitelist_ext = ["jpeg", "jpg", "png", "gif", "bmp"];
                    whitelist_mime = ["image/jpg", "image/jpeg", "image/png", "image/gif", "image/bmp"];
                } else {
                    btn_choose = "Drop files here or click to choose";
                    no_icon = "ace-icon fa fa-cloud-upload";

                    whitelist_ext = null;//all extensions are acceptable
                    whitelist_mime = null;//all mimes are acceptable
                }
                var file_input = $('#id-input-file-3');
                file_input
                    .ace_file_input('update_settings',
                        {
                            'btn_choose': btn_choose,
                            'no_icon': no_icon,
                            'allowExt': whitelist_ext,
                            'allowMime': whitelist_mime
                        })
                file_input.ace_file_input('reset_input');

                file_input
                    .off('file.error.ace')
                    .on('file.error.ace', function (e, info) {
                        //console.log(info.file_count);//number of selected files
                        //console.log(info.invalid_count);//number of invalid files
                        //console.log(info.error_list);//a list of errors in the following format

                        //info.error_count['ext']
                        //info.error_count['mime']
                        //info.error_count['size']

                        //info.error_list['ext']  = [list of file names with invalid extension]
                        //info.error_list['mime'] = [list of file names with invalid mimetype]
                        //info.error_list['size'] = [list of file names with invalid size]


                        /**
                         if( !info.dropped ) {
							//perhapse reset file field if files have been selected, and there are invalid files among them
							//when files are dropped, only valid files will be added to our file array
							e.preventDefault();//it will rest input
						}
                         */


                        //if files have been selected (not dropped), you can choose to reset input
                        //because browser keeps all selected files anyway and this cannot be changed
                        //we can only reset file field to become empty again
                        //on any case you still should check files with your server side script
                        //because any arbitrary file can be uploaded by user and it's not safe to rely on browser-side measures
                    });


                /**
                 file_input
                 .off('file.preview.ace')
                 .on('file.preview.ace', function(e, info) {
						console.log(info.file.width);
						console.log(info.file.height);
						e.preventDefault();//to prevent preview
					});
                 */

            });

            $('#spinner1').ace_spinner({
                value: 0,
                min: 0,
                max: 200,
                step: 10,
                btn_up_class: 'btn-info',
                btn_down_class: 'btn-info'
            })
                .closest('.ace-spinner')
                .on('changed.fu.spinbox', function () {
                    //console.log($('#spinner1').val())
                });
            $('#spinner2').ace_spinner({
                value: 0,
                min: 0,
                max: 10000,
                step: 100,
                touch_spinner: true,
                icon_up: 'ace-icon fa fa-caret-up bigger-110',
                icon_down: 'ace-icon fa fa-caret-down bigger-110'
            });
            $('#spinner3').ace_spinner({
                value: 0,
                min: -100,
                max: 100,
                step: 10,
                on_sides: true,
                icon_up: 'ace-icon fa fa-plus bigger-110',
                icon_down: 'ace-icon fa fa-minus bigger-110',
                btn_up_class: 'btn-success',
                btn_down_class: 'btn-danger'
            });
            $('#spinner4').ace_spinner({
                value: 0,
                min: -100,
                max: 100,
                step: 10,
                on_sides: true,
                icon_up: 'ace-icon fa fa-plus',
                icon_down: 'ace-icon fa fa-minus',
                btn_up_class: 'btn-purple',
                btn_down_class: 'btn-purple'
            });

            //$('#spinner1').ace_spinner('disable').ace_spinner('value', 11);
            //or
            //$('#spinner1').closest('.ace-spinner').spinner('disable').spinner('enable').spinner('value', 11);//disable, enable or change value
            //$('#spinner1').closest('.ace-spinner').spinner('value', 0);//reset to 0


            //datepicker plugin
            //link
            $('.date-picker').datepicker({
                autoclose: true,
                todayHighlight: true
            })
                //show datepicker when clicking on the icon
                .next().on(ace.click_event, function () {
                $(this).prev().focus();
            });

            //or change it into a date range picker
            $('.input-daterange').datepicker({autoclose: true});


            //to translate the daterange picker, please copy the "examples/daterange-fr.js" contents here before initialization
            $('input[name=date-range-picker]').daterangepicker({
                'applyClass': 'btn-sm btn-success',
                'cancelClass': 'btn-sm btn-default',
                locale: {
                    applyLabel: 'Apply',
                    cancelLabel: 'Cancel',
                }
            })
                .prev().on(ace.click_event, function () {
                $(this).next().focus();
            });


            $('#timepicker1').timepicker({
                minuteStep: 1,
                showSeconds: true,
                showMeridian: false,
                disableFocus: true,
                icons: {
                    up: 'fa fa-chevron-up',
                    down: 'fa fa-chevron-down'
                }
            }).on('focus', function () {
                $('#timepicker1').timepicker('showWidget');
            }).next().on(ace.click_event, function () {
                $(this).prev().focus();
            });


            if (!ace.vars['old_ie']) $('#date-timepicker1').datetimepicker({
                //format: 'MM/DD/YYYY h:mm:ss A',//use this option to display seconds
                icons: {
                    time: 'fa fa-clock-o',
                    date: 'fa fa-calendar',
                    up: 'fa fa-chevron-up',
                    down: 'fa fa-chevron-down',
                    previous: 'fa fa-chevron-left',
                    next: 'fa fa-chevron-right',
                    today: 'fa fa-arrows ',
                    clear: 'fa fa-trash',
                    close: 'fa fa-times'
                }
            }).next().on(ace.click_event, function () {
                $(this).prev().focus();
            });


            $('#colorpicker1').colorpicker();
            //$('.colorpicker').last().css('z-index', 2000);//if colorpicker is inside a modal, its z-index should be higher than modal'safe

            $('#simple-colorpicker-1').ace_colorpicker();
            //$('#simple-colorpicker-1').ace_colorpicker('pick', 2);//select 2nd color
            //$('#simple-colorpicker-1').ace_colorpicker('pick', '#fbe983');//select #fbe983 color
            //var picker = $('#simple-colorpicker-1').data('ace_colorpicker')
            //picker.pick('red', true);//insert the color if it doesn't exist


            $(".knob").knob();


            var tag_input = $('#form-field-tags');
            try {
                tag_input.tag(
                    {
                        placeholder: tag_input.attr('placeholder'),
                        //enable typeahead by specifying the source array
                        source: ace.vars['US_STATES'],//defined in ace.js >> ace.enable_search_ahead
                        /**
                         //or fetch data from database, fetch those that match "query"
                         source: function(query, process) {
						  $.ajax({url: 'remote_source.php?q='+encodeURIComponent(query)})
						  .done(function(result_items){
							process(result_items);
						  });
						}
                         */
                    }
                )

                //programmatically add/remove a tag
                var $tag_obj = $('#form-field-tags').data('tag');
                $tag_obj.add('Programmatically Added');

                var index = $tag_obj.inValues('some tag');
                $tag_obj.remove(index);
            } catch (e) {
                //display a textarea for old IE, because it doesn't support this plugin or another one I tried!
                tag_input.after('<textarea id="' + tag_input.attr('id') + '" name="' + tag_input.attr('name') + '" rows="3">' + tag_input.val() + '</textarea>').remove();
                //autosize($('#form-field-tags'));
            }


            /////////
            $('#modal-form input[type=file]').ace_file_input({
                style: 'well',
                btn_choose: 'Drop files here or click to choose',
                btn_change: null,
                no_icon: 'ace-icon fa fa-cloud-upload',
                droppable: true,
                thumbnail: 'large'
            })

            //chosen plugin inside a modal will have a zero width because the select element is originally hidden
            //and its width cannot be determined.
            //so we set the width after modal is show
            $('#modal-form').on('shown.bs.modal', function () {
                if (!ace.vars['touch']) {
                    $(this).find('.chosen-container').each(function () {
                        $(this).find('a:first-child').css('width', '210px');
                        $(this).find('.chosen-drop').css('width', '210px');
                        $(this).find('.chosen-search input').css('width', '200px');
                    });
                }
            })
            /**
             //or you can activate the chosen plugin after modal is shown
             //this way select element becomes visible with dimensions and chosen works as expected
             $('#modal-form').on('shown', function () {
					$(this).find('.modal-chosen').chosen();
				})
             */


            $(document).one('ajaxloadstart.page', function (e) {
                autosize.destroy('textarea[class*=autosize]')

                $('.limiterBox,.autosizejs').remove();
                $('.daterangepicker.dropdown-menu,.colorpicker.dropdown-menu,.bootstrap-datetimepicker-widget.dropdown-menu').remove();
            });

        });
    </script>

    {{-- delete author--}}
    <script language="JavaScript" type="text/javascript">
        $(document).ready(function(){
            $('.delete-btn').click(function(e){
                let authorName = $(this).closest('tr').find('#authorName').text()
                if(!confirm('Are you sure deleting author: '+ authorName)){
                    e.preventDefault();
                    return false;
                }
                return true;
            });
        });
    </script>
@endsection
