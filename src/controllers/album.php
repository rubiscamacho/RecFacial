<?php

use Psr\Http\Message\ServerRequestInterface;





$app

    ->get(
        '/album', function () use ($app) {

        $view = $app->service('view.renderer');
        $repository = $app->service('galeria.repository');
        $oFuncionario = new \SONFin\Models\Funcionario();
        $id_funcionario = SONFin\Models\Galeria::query()
            ->selectRaw('*, count(1) as total')
            ->from('galerias')
            ->groupBy('funcionario_id')
            ->get();


        return $view->render(
            'album/list.html.twig', [

                'galerias' => $id_funcionario,

            ]
        );

    }, 'album.list'
    )

    ->get(
        '/album/{id}/list', function (ServerRequestInterface $request) use ($app) {

        $view = $app->service('view.renderer');

        $repository = $app->service('galeria.repository');

        $id = $request->getAttribute('id');
        $aFotos = SONFin\Models\Galeria::query()
            ->select('*')
            ->from('galerias')
            ->where('funcionario_id', '=', $id)
            ->get();

        return $view->render(
            'album/albumshow.html.twig',
            [

                'galerias' => $aFotos
            ]
        );

    }, 'album.albumshow'
    )

    ->get(
        '/album/{id}/show', function (ServerRequestInterface $request) use ($app) {

        $view = $app->service('view.renderer');
        $repository = $app->service('galeria.repository');
        $id = $request->getAttribute('id');
        $galeria = $repository->findOneBy(
            [

                'id' => $id,

            ]
        );

        return $view->render(
            'album/show.html.twig', [

                'galeria' => $galeria

            ]
        );

    }, 'album.show'
    )

    ->get(
        '/album/{id}/delete', function (ServerRequestInterface $request) use ($app) {

        $repository = $app->service('galeria.repository');
        $repositoryFuncionario = $app->service('funcionario.repository');

        $id = $request->getAttribute('id');

        $nomeFoto = new \SONFin\Models\Galeria();
        $foto = $nomeFoto->find($id)->toArray();

        $funcionario = new \SONFin\Models\Funcionario();
        $nomeFuncionario = $funcionario->find($foto['funcionario_id'])->toArray();




        $diretorio = "/home/rubis/Documentos/TCC/public/galeria/". $nomeFuncionario['first_name'] . '/' . $foto['name'];

        unlink($diretorio);
        $repository->delete(
            [

                'id' => $id

            ]
        );




        return $app->route('album.list');

    }, 'album.delete'
    );





