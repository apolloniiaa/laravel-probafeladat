<?php

test('the home page renders the landing page', function () {
    $response = $this->get(route('home'));

    $response->assertOk()
        ->assertViewIs('home')
        ->assertSee('lang="hu"', false)
        ->assertSee('Tárgyak, amelyek kiállják az idő próbáját')
        ->assertSee('Munkáink')
        ->assertSee('Acél kényelmi eszközök')
        ->assertSee('id="contact-modal"', false);
});
