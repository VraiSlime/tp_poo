<?php include __DIR__ . '/../_templates/_header.html.php'; ?>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6 mt-5">
            <div class="card">
                <div class="card-header bg-primary text-white text-center">
                    Connexion
                </div>
                <div class="card-body">
                    <?php if($auth::isAuth()) $auth::redirect('/'); ?>  

                    <?php
                  if ($form_result && $form_result->hasError() && count($form_result->getErrors()) > 0): ?>
                    <div class="alert alert-danger">
                        <?php echo $form_result->getErrors()[0]->getMessage(); ?>
                    </div>
                <?php endif; ?>
                
                    <form action="/login" method="post">
                        <div class="form-group mb-3">
                            <label for="email">Email:</label>
                            <input type="email" name="email" id="email" class="form-control" placeholder="Entrez votre email" required>
                        </div>
                        <div class="form-group mb-3">
                            <label for="password">Mot de passe:</label>
                            <input type="password" name="password" id="password" class="form-control" placeholder="Entrez votre mot de passe" required>
                        </div>
                        <button type="submit" class="btn btn-primary btn-block mx-auto d-block">GO!</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?php include __DIR__ . '/../_templates/_footer.html.php'; ?>
