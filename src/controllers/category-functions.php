<?php

use Psr\Http\Message\ServerRequestInterface;


$app
    ->get(
        '/category-functions', function () use ($app) {
            $view = $app->service('view.renderer');
            $repository = $app->service('category-function.repository');
            $auth = $app->service('auth');
            $categories = $repository->findByField('user_id', $auth->user()->getId());


            return  $view->render(
                'category-functions/list.html.twig', [
                'categories' => $categories
                ]
            );

        }, 'category-functions.list'
    )
    ->get(
        '/category-functions/new', function () use ($app) {
            $view = $app->service('view.renderer');
            return  $view->render('category-functions/create.html.twig');
        }, 'category-functions.new'
    )

    ->post(
        '/category-functions/store', function (ServerRequestInterface $request) use ($app) {
            $data = $request->getParsedBody();
            $repository = $app->service('category-function.repository');
            $auth = $app->service('auth');
            $data['user_id'] = $auth->user()->getId();
            $repository->create($data);
            return $app->route('category-functions.list');
        }, 'category-functions.store'
    )

    ->get(
        '/category-functions/{id}/edit', function (ServerRequestInterface $request) use ($app) {
            $view = $app->service('view.renderer');
            $repository = $app->service('category-function.repository');
            $id = $request->getAttribute('id');
            $auth = $app->service('auth');
            $category = $repository->findOneBy(
                [
                'id' => $id,
                'user_id' => $auth->user()->getId()
                ]
            );
            return  $view->render(
                'category-functions/edit.html.twig', [
                'category' => $category
                ]
            );
        }, 'category-functions.edit'
    )

    ->post(
        '/category-functions/{id}/update', function (ServerRequestInterface $request) use ($app) {
            $repository = $app->service('category-function.repository');
            $id = $request->getAttribute('id');
            $data = $request->getParsedBody();
            $auth = $app->service('auth');
            $data['user_id'] = $auth->user()->getId();
            $repository->update(
                [
                'id' => $id,
                'user_id' => $auth->user()->getId()
                ], $data
            );
            return $app->route('category-functions.list');
        }, 'category-functions.update'
    )

    ->get(
        '/category-functions/{id}/show', function (ServerRequestInterface $request) use ($app) {
            $view = $app->service('view.renderer');
            $repository = $app->service('category-function.repository');
            $id = $request->getAttribute('id');
            $auth = $app->service('auth');
            $category = $repository->findOneBy(
                [
                'id' => $id,
                'user_id' => $auth->user()->getId()
                ]
            );
            return  $view->render(
                'category-functions/show.html.twig', [
                'category' => $category
                ]
            );
        }, 'category-functions.show'
    )

    ->get(
        '/category-functions/{id}/delete', function (ServerRequestInterface $request) use ($app) {
            $repository = $app->service('category-function.repository');
            $id = $request->getAttribute('id');
            $auth = $app->service('auth');
            $repository->delete(
                [
                'id' => $id,
                'user_id' => $auth->user()->getId()
                ]
            );
            return $app->route('category-functions.list');
        }, 'category-functions.delete'
    );

