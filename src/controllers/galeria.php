<?php

use Psr\Http\Message\ServerRequestInterface;





$app

    ->get(
        '/galeria', function () use ($app) {

        $view = $app->service('view.renderer');
        $repository = $app->service('galeria.repository');
        $galeria = new \SONFin\Models\Galeria();
        $galerias = $galeria->all();

        return $view->render(
            'galeria/list.html.twig', [

                'galerias' => $galerias

            ]
        );

    }, 'galeria.list'
    )

    ->get(
        '/galeria/new', function () use ($app) {

        $view = $app->service('view.renderer');
        $auth = $app->service('auth');
        $funcionarioRepository = $app->service('funcionario.repository');
        $oFuncionario = new \SONFin\Models\Funcionario();
        $galeriasFuncionario = $oFuncionario->all();


        return $view->render('galeria/create.html.twig',[

            'funcionario' => $galeriasFuncionario

        ]);
    }, 'galeria.new')
    ->post(
        '/galeria/store', function (ServerRequestInterface $request) use ($app) {

        $funcionarioRepository = $app->service('funcionario.repository');
        $oFuncionario = new \SONFin\Models\Funcionario();
        $galeriasFuncionario = $oFuncionario->all()->toArray();


        $foto = $_FILES["arquivo"];
        $dimensoes = getimagesize($foto["tmp_name"]);
        preg_match("/\.(gif|bmp|png|jpg|jpeg){1}$/i", $foto["name"], $ext);



        // Gera um nome único para a imagem
        $nome_imagem = md5(uniqid(time())) . "." . $ext[1];
        //$caminho_imagem = "/home/rubis/Documentos/TCC/public/galeria/" . $nome_imagem;

        //move_uploaded_file($foto["tmp_name"], $caminho_imagem);

        $data = $request->getParsedBody();
      // Fazer diretorio com nome do funcionario//
          for ($i = 0; $i < count($galeriasFuncionario); $i++) {
              $dir = "/home/rubis/Documentos/TCC/public/galeria/";
              $NomePasta = $dir . $galeriasFuncionario[$i]['first_name'] . "/";
              $caminho_imagem = $NomePasta . $nome_imagem;
              if ($galeriasFuncionario[$i]['id'] == $data['funcionario_id']){

                  if (is_dir($NomePasta)) {
                      move_uploaded_file($foto["tmp_name"], $caminho_imagem);

                  } else {
                      mkdir("$NomePasta", 0777);
                      move_uploaded_file($foto["tmp_name"], $caminho_imagem);

                  }
                  break;
              }





        }
        $repository = $app->service('galeria.repository');
        $funcionarioRepository = $app->service('funcionario.repository');


        $data['name'] = $nome_imagem;
        $data['funcionario_id'] = $data['funcionario_id'];



        $repository->create($data);
        return $app->route('galeria.list');
    }, 'galeria.store'
    )

    ->get(
        '/galeria/{id}/edit', function (ServerRequestInterface $request) use ($app) {

        $view = $app->service('view.renderer');

        $repository = $app->service('galeria.repository');

        $id = $request->getAttribute('id');
        $oFuncionario = new \SONFin\Models\Funcionario();
        $galeriasFuncionario = $oFuncionario->all();

        $galeria = $repository->findOneBy(
            [

                'id' => $id,


            ]
        );


        return $view->render(
            'galeria/edit.html.twig',
            [

                'galeria' => $galeria,
                'funcionario' => $galeriasFuncionario


            ]
        );

    }, 'galeria.edit'
    )

    ->post(
        '/galeria/{id}/update', function (ServerRequestInterface $request) use ($app) {

        $repository = $app->service('galeria.repository');
        $funcionarioRepository = $app->service('funcionario.repository');
        $id = $request->getAttribute('id');
        $data = $request->getParsedBody();
        $data['name'] = ($data['name']);
        $data['funcionario_id'] = $funcionarioRepository->findOneBy(
            [
                'id' => $data['funcionario_id']
            ]
        )->id;

        $repository->update(
            [

                'id' => $id

            ], $data
        );

        return $app->route('galeria.list');

    }, 'galeria.update'
    )

    ->get(
        '/galeria/{id}/show', function (ServerRequestInterface $request) use ($app) {

        $view = $app->service('view.renderer');
        $repository = $app->service('galeria.repository');
        $id = $request->getAttribute('id');
        $galeria = $repository->findOneBy(
            [

                'id' => $id,

            ]
        );

        return $view->render(
            'galeria/show.html.twig', [

                'galeria' => $galeria

            ]
        );

    }, 'galeria.show'
    )

    ->get(
        '/galeria/{id}/delete', function (ServerRequestInterface $request) use ($app) {

        $repository = $app->service('galeria.repository');
        $repositoryFuncionario = $app->service('funcionario.repository');

        $funcionario = new \SONFin\Models\Funcionario();
        $nomeFuncionario = $funcionario->all()->toArray();
        $id = $request->getAttribute('id');
        $nomeFoto = new \SONFin\Models\Galeria();
        $foto = $nomeFoto->all()->toArray();

        $nomeFoto = $request->getAttribute('name');
       // $caminho_imagem = "/home/rubis/Documentos/TCC/public/galeria/" . $nomeFoto;
        $dir = "/home/rubis/Documentos/TCC/public/galeria/";
            array_column($foto,'funcionario_id','id');


        for($i = 0; $i < count($foto); ++$i) {
            if ($foto[$i]['id'] = $id){
                $fotoNome = $foto[$i]['name'];
                for ($f = 0; $f < count($nomeFuncionario);$f++) {
                    if ($nomeFuncionario[$f]['id'] = array_column($nomeFuncionario, 'id')){
                        $dirFuncionario = $nomeFuncionario[$f]['first_name'] . "/";
                        unlink($dir . $dirFuncionario . $fotoNome);
                    }

                                //Exclui diretorio se vazio
                    /*if (!file_exists($dir . $dirFuncionario)) {
                        rmdir($dir . $dirFuncionario);

                    }*/
                }

            }
            break;

        }

        $repository->delete(
            [

                'id' => $id


            ]
        );


        return $app->route('galeria.list');

    }, 'galeria.delete'
    );