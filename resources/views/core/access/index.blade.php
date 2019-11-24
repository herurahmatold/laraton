<?php
if (!empty($group_access)) {
    ?>
    <form method="post" id="frmaccess">
        @csrf
        <input type="hidden" name="name" value="{{ $name }}" />
        <input type="hidden" name="title" value="{{ $title }}" />
        <ul class="sticky-access-group">
            <?php
                foreach ($group_access as $r) 
                {
                    $ck='';
                    if($r['access']==true)
                    {
                        $ck='checked=""';
                    }
                ?>
                <li>
                    <label class="checkbox-inline">
                        <input type="checkbox" name="user_group[]" <?=$ck;?> value="<?=$r['group_id'];?>" />
                        <span><?= $r['group_value']; ?></span>
                    </label>
                </li>
            <?php
                }
                ?>
        </ul>
        <hr />
        <p>
            <button type="button" class="btn btn-default btn-flat btn-sm pull-right" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary btn-flat btn-sm pull-right" style="margin-right:20px">Submit</button>
        </p>
        <div class="clearfix"></div>
    </form>
<?php
}
?>

<script>
    $(document).ready(function() {

        $("#frmaccess").on('submit', function(e) {
            e.preventDefault();
            $.ajax({
                    url: "{{ route('access.update') }}",
                    data: $(this).serialize(),
                    type: "post",
                    dataType: "json",
                    beforeSend: function() {
                        overlay_show();
                    },
                })
                .done(function(x) {
                    if (x.status == true) {
                        alert(x.message);
                        $("#modal-access").modal('hide');
                    } else {
                        alert(x.message);
                    }
                    overlay_hide();
                })
                .fail(function() {
                    alert('Server not respond');
                    overlay_hide();
                })
                .always(function() {

                });
        });

    });
</script>