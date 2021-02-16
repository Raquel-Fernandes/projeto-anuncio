<?php

add_action('admin_menu', 'anuncio_Add_Admin_Link');


global $wpdb;
require_once(ABSPATH . 'wp-admin/includes/upgrade.php');

$uploaddir =  ABSPATH . 'wp-content/uploads/images/';
if ($_POST["nome"]) {
    $nome = $_POST["nome"];
    $descricao = $_POST["descricao"];
    $tags = $_POST["tags"];
    $uploadfile = $uploaddir . basename($_FILES['imageUpload']['name']);
    move_uploaded_file($_FILES['imageUpload']['tmp_name'], $uploadfile);

    $url = 'wp-content/uploads/images/' . $_FILES['imageUpload']['name'];

    $tablename = $wpdb->prefix . 'custom_anuncio';

    $wpdb->insert(
        $tablename,
        array(
            'ds_nome' => $_POST['nome'],
            'ds_descricao' => $_POST['descricao'],
            'ds_tags' => $_POST['tags'],
            'ds_link_imagem' => $url,
            'dt_registro' => date('Y-m-d H:i:s')
        ),
        array('%s', '%s', '%s', '%s', '%s')
    );
}


function anuncio_Add_Admin_Link()
{
    add_menu_page(
        'Anuncio Page', // Title of the page
        'Anuncio', // Text to show on the menu link
        'manage_options',
        'anuncio-page',
        //'includes/anuncio-view.php',
        'view',
        '',
        200
    );
}

function view()
{
?>
    <html>

    <head>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
        <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>
    </head>

    <body>
        <div class="wrap">
            <h1>Anúncios</h1>
            <button class="btn btn-primary" data-toggle="collapse" data-target="#addAnuncio" role="button" aria-expanded="false" aria-controls="addAnuncio">
                Cadastrar Novo Anuncio
            </button>
            <button class="btn btn-primary" data-toggle="collapse" data-target="#viewAnuncio" role="button" aria-expanded="false" aria-controls="viewAnuncio">
                Anuncios cadastrados
            </button>

            <div class="collapse" id="addAnuncio" style="margin-top:5px;">
                <div class="container">
                    <form action="" method="post" enctype="multipart/form-data">
                        <div class="row">
                            <div class="col-sm-3">
                                <label for="">Nome</label>
                                <input type="text" name="nome" />
                            </div>
                            <div class="col-sm-3">
                                <label for="">Descrição</label>
                                <input type="text" name="descricao" />
                            </div>
                            <div class="col-sm-3">
                                <label for="">Tags</label></br>
                                <input type="text" name="tags" />
                            </div>
                        </div>
                        <div class="row" style="margin-top:5px;">
                            <div class="col-sm-9">
                                <label for="">Upload de imagens</label></br>
                                <input name="imageUpload" type='file' id="imageUpload" accept=".png, .jpg, .jpeg" />
                            </div>
                        </div>
                        <input style="margin-top:5px;" type="submit" value="Cadastrar" class="btn btn-primary">
                    </form>
                </div>

            </div>
            <div class="collapse" id="viewAnuncio" style="margin-top:5px;">
                <div class="container">
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">Nome</th>
                                <th scope="col">Descrição</th>
                                <th scope="col">Tags</th>
                                <th scope="col">Imagem</th>
                                <th scope="col">Ação</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $request_uri = $_SERVER['REQUEST_URI'];
                            $request_uri = explode("/", $request_uri);
                            $request_uri = $request_uri[1];
                            $url = $_SERVER['SERVER_NAME'] . '/' .$request_uri .'/';
                            global $wpdb;
                            $table_name = $wpdb->prefix . 'custom_anuncio';
                            $post_id = $wpdb->get_results("SELECT * FROM $table_name");
                            foreach($post_id as $value) {
                                echo "<tr>";
                                echo "<td>" . $value->ds_nome . "</td>";
                                echo "<td>" . $value->ds_descricao . "</td>";
                                echo "<td>" . $value->ds_tags . "</td>";
                                echo '<td> <img src="' .$url . $value->ds_link_imagem .'" width="50" height="50"></td>';
                                echo '<td> <i class="far fa-edit"></i> <i class="fas fa-trash-alt"></i></td>';
                                echo "</tr>";
                            }
                            ?>
                        </tbody>
                    </table>

                </div>

            </div>
        </div>

        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    </body>


    </html>
<?php
}
