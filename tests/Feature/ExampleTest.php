<?php

it('renders the public homepage for guests', function () {
    $response = $this->get('/');

    $response->assertOk();
    $response->assertSee('Royalty Sacco');
});
