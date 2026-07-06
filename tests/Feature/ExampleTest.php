<?php

it('redirects guests from the root to the dashboard', function () {
    $response = $this->get('/');

    $response->assertRedirect(route('dashboard'));
});
