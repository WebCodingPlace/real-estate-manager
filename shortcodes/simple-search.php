<div class="ich-settings-main-wrap">
    <div class="rem-simple-search" style="max-width: <?php echo $width; ?>; margin:0 auto;border-color: <?php echo $border_color; ?> !important;">
        <form method="GET" action="<?php echo $results_page; ?>">
            <div class="input-group">
                <input name="simple_search" type="text" class="form-control input-lg" value="<?php echo (isset($_GET['simple_search'])) ? esc_attr($_GET['simple_search']) : '' ; ?>" placeholder="<?php echo $placeholder; ?>" />
                <span class="input-group-btn">
                    <button class="btn btn-info btn-lg" type="submit" style="border-color: <?php echo $border_color; ?> !important;">
                        <?php echo $search_icon; ?>
                    </button>
                </span>
            </div>
        </form>
    </div>
</div>