{include file='header' pageTitle='de.cryptonica.oauth2server.authclient.list'}

<header class="contentHeader">
    <div class="contentHeaderTitle">
        <h1 class="contentTitle">{lang}de.cryptonica.oauth2server.authclient.list{/lang}</h1>
    </div>

    {hascontent}
        <nav class="contentHeaderNavigation">
            <ul>
                {content}
                    <li>
                        <a href="{link controller='AuthClientAdd'}{/link}" title="{lang}wcf.global.button.add{/lang}" class="button">
                            <span class="icon icon16 fa-plus"></span>
                            <span>{lang}wcf.global.button.add{/lang}</span>
                        </a>
                    </li>
                {event name='contentHeaderNavigation'}
                {/content}
            </ul>
        </nav>
    {/hascontent}
</header>

{include file='formError'}

<section class="section">
    {if $clients|count}
        <table class="table">
            <thead>
            <tr>
                <th>Beschreibung</th>
                <th>ClientID</th>
                <th>Client Secret</th>
                <th colspan="2">Callback</th>
            </tr>
            </thead>
            <tbody>
            {foreach from=$clients item=client}
                <tr>
                    <td>{$client->description}</td>
                    <td>{$client->clientID}</td>
                    <td>{$client->clientSecret}</td>
                    <td>{$client->callbackUrl}</td>
                </tr>
            {/foreach}
            </tbody>
        </table>
    {else}
        <p class="info">{lang}wcf.global.noItems{/lang}</p>
    {/if}
</section>

{include file='footer'}