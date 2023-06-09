<?= $this->extend('auth/template') ?>

<?= $this->section('content') ?>

<style>
    body 
    {
        background: linear-gradient(135deg, #1e5799 0%,#2989d8 50%,#207cca 100%);
    }

    /* Animasi efek fade in pada card saat dimuat */
.card {
  opacity: 0;
  transform: translateY(-50%);
  animation: fade-in 0.8s ease forwards;
}

@keyframes fade-in {
  to {
    opacity: 1;
    transform: translateY(0%);
  }
}

/* Animasi efek scale dan shadow pada form saat di hover */
.form-floating input,
.form-floating label {
  transition: all 0.3s ease;
}

.form-floating input:hover,
.form-floating label:hover {
  transform: scale(1.1);
  box-shadow: 0 0 20px rgba(0, 0, 0, 0.2);
}

/* Animasi efek slide in pada tombol register saat dimuat */
.card-footer {
  opacity: 0;
  transform: translateY(50%);
  animation: slide-in 0.8s ease forwards;
}

@keyframes slide-in {
  to {
    opacity: 1;
    transform: translateY(0%);
  }
}

/* Animasi efek pulsing pada tombol login saat di hover */
.btn-primary:hover {
  animation: pulsing 1s ease infinite;
}

@keyframes pulsing {
  0% {
    transform: scale(1);
  }
  50% {
    transform: scale(1.2);
  }
  100% {
    transform: scale(1);
  }
}


</style>

<main>
                    <div class="container">
                        <div class="row justify-content-center">
                            <div class="col-lg-7">
                                <div class="card shadow-lg border-0 rounded-lg mt-5">
                                    <div class="card-header">
                                        <h3 class="text-center font-weight-light my-4">Create Account</h3>
                                    </div>
                                    <div class="card-body">
                                        <?php if(isset($validation)) :?>
                                            <div class="alert alert-danger"><?= $validation->listErrors() ?></div>
                                        <?php endif; ?>
                                        <form action="/login/save" method="post">
                                            <? csrf_field() ?>
                                            <div class="form-floating mb-3">
                                                <input class="form-control <?php if(session('error.email')): ?>is-invalid<?php endif ?>" name="email" type="email" placeholder="Email" 
                                                value="<?= old('email') ?>" />
                                                <label for="inputEmail">Email</label>
                                                </div>

                                                <div class="form-floating mb-3">
                                                <input class="form-control <?php if(session('error.username')): ?>is-invalid<?php endif ?>" name="username"  placeholder="Username" 
                                                value="<?= old('username') ?>" />
                                                <label for="inputEmail">Username</label>
                                                </div>
                                        
                                                <div class="row mb-3">
                                                <div class="col-md-6">
                                                    <div class="form-floating mb-3 mb-md-0">
                                                        <input type="password" name="password" class="form-control <?php if(session('error.password')): ?>is-invalid<?php endif ?>" placeholder="Password" autocomplete="off"/>
                                                        <label for="inputPassword">Password</label>
                                                    </div>
                                                </div>

                                                
                                                <div class="col-md-6">
                                                    <div class="form-floating mb-3 mb-md-0">
                                                        <input type="password" name="pass_confirm" class="form-control <?php if(session('error.pass_confirm')): ?>is-invalid<?php endif ?>" placeholder="Repeat Password" autocomplete="off"/>
                                                        <label for="inputPasswordConfirm">Repeat Password</label>
                                                    </div>
                                                </div>
                                             </div>

                                         <div class="mt-4 mb-0">
                                            <div class="d-grid">
                                                <button type="submit" class="btn btn-primary btn-block" >Register</button>
                                         </div>
                                            </div>
                                           
                                        </form>
                                    </div>
                                    <div class="card-footer text-center py-3">
                                        <div class="small">Have an account? Go to login <a href="/login">Login</a></div>
                                        
                                    </div>
                                    
                                </div>
                            </div>
                            <div class="card-footer text-center py-3">
                            </div>
                        </div>
                    </div>
                </main>
                <?= $this->endSection() ?>