<?php

    if (!Post('save', false) && !Post('delete', false))
            Location('/admin/catalog/index');

    if (Post('delete', false))
    {
        $_cat = new Catalog(Post('id'));
        unlink(BASEPATH . 'upl/catalog/' . $_cat->image);
        unlink(BASEPATH . 'upl/catalog/small/' . $_cat->image);
        $_cat->Delete();
        Location('/admin/catalog/list?category=' . Post('category_id'));
    }

    $_cat = (Post('id', false)) ? new Catalog(Post('id')) : new Catalog();

    $_cat->name = Post('name');
    $_cat->desc = Post('desc');
    $_cat->text = Post('text');
    $_cat->cost = intval(Post('cost', 0));
    $_cat->discount = intval(Post('discount', 0));
    $_cat->time = time();
    $_cat->category_id = Post('category_id');

    if (!empty($_FILES['image']['tmp_name']))
    {
        
        include_once BASEPATH . 'lib/WideImage/WideImage.php';

        $image = WideImage::load($_FILES['image']['tmp_name']);
        $img = md5($_FILES['image']['tmp_name'] . time()) . '.' . GetExt($_FILES['image']['name']);
        $image->saveToFile(BASEPATH . 'upl/catalog/' . $img);

        global $g_config;

        $width  = $g_config['catalog']['image_preview_size']['width'];
        $height = $g_config['catalog']['image_preview_size']['height'];

        $image = WideImage::load($_FILES['image']['tmp_name']);
        $image->resize($width, $height, 'fill')->saveToFile(BASEPATH . 'upl/catalog/small/' . $img);
        $_cat->image = $img;
    }

    Location('/admin/catalog/list?category=' . Post('category_id'));

?>