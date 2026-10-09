<form action="<?= $dirs->webRoot; ?>/auth/signin" method="post" class="auth-form">
    <div class="panel">
        <img src="<?= $dirs->webRoot; ?>/public/images/illustration.png" alt="Illustration of the world's famous attractions." class="pic" title="Illustration of Eiffel Tower, Empire State Building, Louvre Pyramid, Pisa Tower and Notre Dame." />
    </div>
    <footer class="err-cntr">
        <span class="hr separator"></span>
        {{@err}}
        <span class="hr separator" style="margin-block: 0;"></span>
    </footer>
    <fieldset>
        <legend class="hidden">Sign In</legend>
        <div class="fields-cntr">
            <p class="field">
                <label for="Email">Email</label>
                <input type="email" name="Email" id="Email" required="required" autocomplete="email" placeholder="example@email.com" />
            </p>
            <p class="field">
                <label for="Pwd">Password</label>
                <input type="password" name="Pwd" id="Pwd" required="required" autocomplete="current-password" placeholder="********" />
            </p>
        </div>
        <p class="field btn">
            <input type="submit" class="btn auth" value="Sign In" />
        </p>
    </fieldset>
    <a href="<?= $dirs->webRoot; ?>/auth/signup" class="link underline" style="align-self: flex-start; color: #fff; margin-top: 1rem;"><p>Don't have an account <span class="separated">?</span></p></a>
</form>