<?php

use Psr\Http\Message\ServerRequestInterface;





$app

    ->get(
        '/galeria', function () use ($app) {

        $view = $app->service('view.renderer');
        $repository = $app->service('galeria.repository');
        $oFuncionario = new \SONFin\Models\Funcionario();
        $id_funcionario = SONFin\Models\Galeria::query()
            ->selectRaw('*, count(1) as total')
            ->from('galerias')
            ->groupBy('funcionario_id')
            ->get();


        return $view->render(
            'galeria/list.html.twig', [

                'galerias' => $id_funcionario,

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

       // flash('Sorry! Please try again.')->error();
        return $app->route('galeria.list');
    }, 'galeria.store'
    )

    ->get(
        '/galeria/album/{id}', function (ServerRequestInterface $request) use ($app) {

        $view = $app->service('view.renderer');

        $repository = $app->service('galeria.repository');

        $id = $request->getAttribute('id');
        $aFotos = SONFin\Models\Galeria::query()
            ->select('*')
            ->from('galerias')
            ->where('funcionario_id', '=', $id)
            ->get();

        return $view->render(
            'galeria/album.html.twig',
            [

                'galerias' => $aFotos
            ]
        );

    }, 'galeria.album'
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

        $id = $request->getAttribute('id');

        $nomeFoto = new \SONFin\Models\Galeria();
        $foto = $nomeFoto->find($id)->toArray();

        $funcionario = new \SONFin\Models\Funcionario();
        $nomeFuncionario = $funcionario->find($foto['funcionario_id'])->toArray();

        $aListaFotos = SONFin\Models\Galeria::query()
            ->select('*')
            ->from('galerias')
            ->where('funcionario_id', '=', $nomeFuncionario['id'])
            ->get();


        $diretorio = "/home/rubis/Documentos/TCC/public/galeria/". $nomeFuncionario['first_name'];

        foreach ($aListaFotos as $aFotoApagar) {

            unlink($diretorio . '/'. $aFotoApagar->toArray()['name']);
            rmdir($diretorio);
            $aFotoApagar->delete();

        }
        
        




        return $app->route('galeria.list');

    }, 'galeria.delete'
    );