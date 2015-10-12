<?php
if (!defined('ABSPATH')) {
    exit;
}

if (!class_exists('WBC_Calendar')) {
    class WBC_Calendar {
        public function __construct() {
            add_action('admin_menu', array($this, 'admin_menu'));

            add_action('wp_ajax_wbc_add_calendar_event', array($this, 'add_calendar_event'));
            //add_action('wp_ajax_nopriv_wbc_add_calendar_event', array($this, 'add_calendar_event'));
            add_action('wp_ajax_wbc_fetch_wbc_events', array($this, 'fetch_wbc_events'));
            add_action('wp_ajax_wbc_delete_calendar_event', array($this, 'delete_calendar_event'));
        }

        public function add_calendar_event() {
            if ($_POST) {
                $post = $_POST;

                $events = json_decode(get_option('_wbc_calendar_event'), true);

                $id  = isset($_POST['event_id']) && !empty($_POST['event_id']) ? $_POST['event_id'] : time();
                $index = $this->get_index_event_id($id);
                $data = array(
                    'id'    => $id,
                    'title'  => esc_attr($post['event_title']),
                    'start'  => date('Y-m-d', strtotime(esc_attr($post['event_date']))),
                );

                if (isset($events[$index])) {
                    $events[$index] = $data;
                } else {
                    $events[] = $data;
                }



                update_option('_wbc_calendar_event', json_encode($events));

                wp_send_json_success(array('events' => json_encode($events)));
                exit;
            }
        }

        public function get_index_event_id($event_id) {

            $events = json_decode(get_option('_wbc_calendar_event'), true);
            if (is_array($events) && count($events) != 0) {

                for ($i = 0; $i < count($events); $i++) {
                    if ($events[$i]['id'] == $event_id) {
                        return $i;
                    }
                }

                return -1;
            }
        }


        public function delete_calendar_event() {
            if (isset($_POST['event_id'])) {

                $events = json_decode(get_option('_wbc_calendar_event'), true);
                $index = $this->get_index_event_id($_POST['event_id']);

                if ($index != -1) {
                    unset($events[$index]);
                    update_option('_wbc_calendar_event', json_encode($events));
                }

                die;
            }
        }

        public function fetch_wbc_events() {
            $events = json_decode(get_option('_wbc_calendar_event'), true);
            //sort($events);

            echo json_encode(array_values($events));
            die;
        }


        public function load_inline_styles() {
            ?>
            <style>
                #calendar {
                    position:relative;
                }
                .wbc_calendar_overlay {
                    position: absolute;
                    top: 0px;
                    left: 0px;
                    bottom: 0px;
                    right: 0px;
                    background-color: rgba(202, 202, 202, 0.490196);
                    z-index: 999;
                    text-align: center;
                }


                .wbc_calendar_overlay .loading {
                    background-color: rgb(255, 255, 255);
                    width: 50%;
                    margin: 30% auto;
                }
            </style>
            <?php
        }




        public function admin_menu() {
            $calendar_page = add_submenu_page('wristband-configuration', 'Calendar', 'Calendar', 'manage_options', 'wristband-configuration-calendar', array($this, 'render_calendar_page'));



            add_action('load-'. $calendar_page, array($this, 'admin_load'));

        }

        public function admin_load() {

            add_action('admin_enqueue_scripts', array($this,'admin_enqueue_scripts'));

            add_action('admin_print_styles', array($this, 'load_inline_styles'));
            add_action('admin_footer', array($this, 'load_calendar_js'));

        }


        public function admin_enqueue_scripts() {

            wp_register_style('full-calendar_style', WBC_ASSETS_URL . '/css/vendor/fullcalendar.css', array(), WBC_VERSION);
            // wp_register_style('full-calendar_print_style', WBC_ASSETS_URL . '/css/vendor/fullcalendar.print.css', array(), WBC_VERSION);

            wp_enqueue_style('full-calendar_style');
            //wp_enqueue_style('full-calendar_print_style');
            //jQuery UI date picker file
            wp_enqueue_script('jquery-ui-datepicker');
            //jQuery UI theme css file
            wp_enqueue_style('e2b-admin-ui-css', '//ajax.googleapis.com/ajax/libs/jqueryui/1.9.0/themes/base/jquery-ui.css',false,"1.9.0",false);



            wp_register_script('moment_js', WBC_ASSETS_URL . '/js/vendor/moment.js', array('jquery'), WBC_VERSION, true);
            wp_register_script('full-calendar_js', WBC_ASSETS_URL . '/js/vendor/fullcalendar.min.js', array('jquery', 'jquery-ui-core', 'jquery-ui-datepicker'), WBC_VERSION, true);
            wp_register_script('mustache_js', WBC_ASSETS_URL . '/js/vendor/mustache.min.js', array('jquery'), WBC_VERSION, true);


            wp_enqueue_script('moment_js');
            wp_enqueue_script('full-calendar_js');
            wp_enqueue_script('mustache_js');

        }


        public function load_calendar_js() {

            $events = get_option('_wbc_calendar_event');
            if (!$events) {
                $events = json_encode(array());
            }
            ?>
            <script>
                jQuery(function($) {

                    $( 'body' )
                        .on( 'click', '#add_calendar_event_button', function(e) {
                            e.preventDefault();
                            var $self    = $(this),
                                $title   = $('#event_title'),
                                $date    = $('#event_date');

                                if ( $title.val() == '' || $date.val() == '' ) return;


                                var data = $(this).closest('form').serialize();


                                $self.text('Processing...');

                            $.post('<?php echo admin_url('admin-ajax.php'); ?>', data + '&action=wbc_add_calendar_event', function(response) {
                                $('#TB_closeWindowButton').trigger('click');

                                $self.text('Add');

                                $('#calendar').fullCalendar( 'refetchEvents' );
                            });
                        })
                        .on( 'click', '#delete_event', function(e) {
                            e.preventDefault();


                            var $self  = $(this),
                                data   = $self.closest('form').serialize();


                            $self.text('Processing...');

                            $.post('<?php echo admin_url('admin-ajax.php'); ?>', data + '&action=wbc_delete_calendar_event', function(response) {
                                $('#TB_closeWindowButton').trigger('click');

                                $self.text('Delete');

                                $('#calendar').fullCalendar( 'refetchEvents' );
                            });


                        });



                    $('#calendar').fullCalendar({
                        customButtons: {
                            addEventButton: {
                                text: 'Add',
                                click: function() {
                                    var template  = $( '#calendar_form_template').html();
                                    var tpl  = Mustache.render( template, {button_text: 'Add', class: 'hidden', date:moment().format('MM/DD/YYYY')} );
                                    $('#calendar_event_wrapper').html(tpl);


                                    tb_show('Add Holiday', '#TB_inline?width=350&height=250&inlineId=calendar_event_wrapper');
                                    $( '#event_date').datepicker();
                                }
                            }
                        },
                        loading: function(isLoading, view) {
                            if( isLoading == false ) {
                                $('.wbc_calendar_overlay').remove();
                            } else {
                                $('#calendar').append('<div class="wbc_calendar_overlay"><div class="loading"><p>Loading...</p></div></div>')
                            }
                        },
                        header: {
                            left: 'prev,next today, addEventButton',
                            center: 'title',
                            right: 'month,agendaWeek,agendaDay'
                        },
                        editable: false,
                        eventLimit: true, // allow "more" link when too many events
                        events: {
                            url : '<?php echo admin_url('admin-ajax.php') . '?action=wbc_fetch_wbc_events'; ?>',//<?php echo $events; ?>,
                        },
                        eventClick: function(calEvent, jsEvent, view) {

                            // change the border color just for fun
//                            $(this).css({'border-color': '#FF004D', 'background-color': '#FF004D'});


                            var template  = $( '#calendar_form_template').html();
                            var tpl  = Mustache.render( template, {button_text: 'Update', id: calEvent.id, title: calEvent.title, date: calEvent.start.format('MM/DD/YYYY')} );

                            $('#calendar_event_wrapper').html(tpl);

                            tb_show('Edit Holiday', '#TB_inline?width=350&height=450&inlineId=calendar_event_wrapper');

                            $( '#event_date').datepicker();
                        }
                    });

                });
            </script>
            <?php
        }

        public function render_calendar_page() {

            ?>
            <div class="wrap">
                <div class="icon32" id="icon-dashicons-calendar"><br></div>
                <h2>Calendar</h2>
                <div id="calendar"></div>
            </div>
            <div id="calendar_event_wrapper" style="display:none;"></div>

            <?php add_thickbox(); ?>
            <script id="calendar_form_template" type="x-tmpl-mustache">
                <form action="#" method="POST">
                    <p>If title is already exists it will override the existing.</p>
                <p>
                <label for="event_title">Title</label><br />
                    <input type="text" id="event_title" name="event_title" class="regular-text" value="{{title}}">
                    </p>
                    <p>
                    <label for="event_date">Date</label><br />
                    <input type="text" id="event_date" name="event_date" class="regular-text"  value="{{date}}">
                    </p>
                    <input type="hidden" name="event_id" value="{{id}}" />
                    <button type="button" id="add_calendar_event_button" class="fc-addEventButton-button fc-button fc-state-default fc-corner-left fc-corner-right">{{button_text}}</button>
                    </form>


                     <form action="#" method="post" class="{{class}}">
                     <h2 class="separator">OR</h2>
                <p>{{title}}</p>
                <p>{{date}}</p>

                <input type="hidden" name="event_id" value="{{id}}" />
                <button type="button" id="delete_event" class="fc-addEventButton-button fc-button fc-state-default fc-corner-left fc-corner-right">Delete</button>
                </form>
            </script>
            <?php

        }

    }
}

new WBC_Calendar();