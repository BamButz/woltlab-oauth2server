{include file='header' pageTitle='wcf.acp.article.'|concat:$action}

<header class="contentHeader">
    <div class="contentHeaderTitle">
        <h1 class="contentTitle">{lang}de.cryptonica.oauth2server.authclient.{$action}{/lang}</h1>
    </div>
</header>

{include file='formError'}

<section class="section">
	<form method="post" action="{link controller='AuthClientAdd'}{/link}">
		<dl {if $errorField == 'description'}class="formError"{/if}>
            <dt><label for="description">{lang}wcf.oauth2server.description{/lang}</label></dt>
            <dd>
                <input type="text" id="description" name="description" value="" required class="long">
                {if $errorField == 'description'}
                    <small class="innerError">
                        {if $errorType == 'empty'}{lang}wcf.global.form.error.empty{/lang}{/if}
                    </small>
                {/if}
                <small>{lang}wcf.oauth2server.description.description{/lang}</small>
            </dd>
        </dl>
		<dl {if $errorField == 'callbackUrl'}class="formError"{/if}>
            <dt><label for="callbackUrl">{lang}wcf.oauth2server.callbackUrl{/lang}</label></dt>
            <dd>
                <input type="text" id="callbackUrl" name="callbackUrl" value="" required class="long">
                {if $errorField == 'callbackUrl'}
                    <small class="innerError">
                        {if $errorType == 'empty'}{lang}wcf.global.form.error.empty{/lang}{/if}
                    </small>
                {/if}
                <small>{lang}wcf.oauth2server.callbackUrl.description{/lang}</small>
            </dd>
        </dl>
		<div class="formSubmit">
        	<input type="submit" value="{lang}wcf.global.button.submit{/lang}" accesskey="s">
        	{@SECURITY_TOKEN_INPUT_TAG}
    	</div>
	</form>
</section>