{include file='header' pageTitle='de.cryptonica.oauth2server.authclient.'|concat:$action}

<header class="contentHeader">
    <div class="contentHeaderTitle">
        <h1 class="contentTitle">{lang}de.cryptonica.oauth2server.authclient.{$action}{/lang}</h1>
    </div>

    <nav class="contentHeaderNavigation">
        <ul>
            {* your default content header navigation buttons *}

            {event name='contentHeaderNavigation'}
        </ul>
    </nav>
</header>

{include file='formError'}

{* content *}

{include file='footer'}