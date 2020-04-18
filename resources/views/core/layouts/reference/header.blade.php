<link rel="shortcut icon" href="<?= app_favicon(200); ?>" />
<script>
    var base_url = '<?= url('/'); ?>';
</script>
<?php
if (user_group_name() == 'superadmin') {
    $route_name=get_route_name();
    
    $route_no_access=laraconfig('global','route_no_access');
    if(!in_array($route_name,$route_no_access))
    {

    
    ?>
    <ul class="sticky-access">
        <li class="sticky-access-item">
            <a href="javascript:;" onclick="show_access('<?= get_route_name(); ?>','<?= $meta['title']; ?>');" class="text-warning">
                <i class="fa fa-lock"></i>
            </a>
        </li>
    </ul>


    <div class="modal" tabindex="-1" role="dialog" id="modal-access">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modal-access-title">&nbsp;</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="modal-access-body">
                </div>
            </div>
        </div>
    </div>



    <script>
        function show_access(name, title) {
            if (typeof name == 'undefined') {
                return false;
            }

            if (name == '') {
                return false;
            }

            if (typeof title == 'undefined') {
                return false;
            }

            if (title == '') {
                return false;
            }

            $.ajax({
                    url: "{{ route('access.show') }}",
                    data: "name=" + name + "&title=" + title,
                    type: "get",
                    dataType: "html",
                    beforeSend: function() {
                        $("#modal-access-title").html(title);
                        $("#modal-access").modal('show');
                    },
                })
                .done(function(x) {
                    $("#modal-access-body").html(x);
                })
                .fail(function() {
                    alert('Server not respond');
                });

        }
    </script>


<?php
    }
}
?>