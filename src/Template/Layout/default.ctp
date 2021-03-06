<?php
/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @since         0.10.0
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

$description = __('CS-Community: Find the best teammates!');
?>

<!-- The default layout used for this application. Loads Javascript and css files and renders e.g. the top bar -->

<!DOCTYPE html>
<html>
<head>
    <?= $this->Html->charset() ?>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        <?= $description ?>:
        <?= $this->fetch('title') ?>
    </title>
    <?= $this->Html->meta('icon') ?>

    <?= $this->Html->css('base.css') ?>
    <?= $this->Html->css('http://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css') ?>
    <?= $this->Html->css('jquery.scrollbar.css') ?>
    <?= $this->Html->css('cake.css') ?>

    <?= $this->fetch('meta') ?>
    <?= $this->fetch('css') ?>
    <?= $this->fetch('script') ?>
    <?= $this->Html->script('https://code.jquery.com/jquery-3.1.1.min.js'); ?>
    <?= $this->Html->script('http://code.jquery.com/ui/1.12.1/jquery-ui.min.js'); ?>

    <?= $this->Html->script('http://autobahn.s3.amazonaws.com/js/autobahn.min.js'); ?>
    <?= $this->Html->script('/webroot/js/update-index.js'); ?>
    <?= $this->Html->script('/webroot/js/jquery.scrollbar.min.js'); ?>
</head>
<body>
<nav class="top-bar" data-topbar role="navigation">
    <ul class="title-area">
        <li class="name">
            <a href="/cs-community">
            <?= $this->Html->image('logograuklein.png', ['alt' => 'logo']); ?>
            <h3><?= __('CS-Community') ?></h3>
            </a>
        </li>
    </ul>
    <section class="top-bar-section">
        <ul class="right">
            <?php if (isset($user)): ?>
                <li class='has-dropdown not-click'>
                    <a href='#'><?= h($user->personaname) ?></a>
                    <ul class="dropdown">
                        <li> <?= $this->Html->link(__('My Profile'), ['controller' => 'users', 'action' => 'view', $user->steam_id]) ?></li>
                        <li><?= $this->Html->link(__('Logout'), ['controller' => 'users', 'action' => 'logout']) ?></li>
                        <li><a href="mailto:varappvr@gmail.com"><?= __('Support') ?></a></li>
                    </ul>
                </li>
                <li><?= $this->Html->image($user->avatar, ['alt' => 'steam_avatar', 'url' => $user->profileurl, 'id' => 'topbar-avatar', 'steam_id' => $user->steam_id, 'playtime' => $user->playtime, 'user_region' => $user_region]); ?></li>
            <?php else: ?>
                <li><?= $this->Html->image("http://cdn.steamcommunity.com/public/images/signinthroughsteam/sits_02.png", [
                        "alt" => __("Steam Login"),
                        'url' => $loginUrl]); ?>
                </li>
            <?php endif; ?>
        </ul>
    </section>
</nav>
<?= $this->Flash->render() ?>
<?= $this->Flash->render('auth') ?>
<div id="errorArea"></div>

<section class="container clearfix">
    <?= $this->fetch('content') ?>
</section>
<footer>
</footer>
</body>
</html>
