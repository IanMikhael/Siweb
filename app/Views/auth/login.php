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
            <div class="col-lg-5">
                <div class="card shadow-lg border-0 rounded-lg mt-5">
                    <div class="card-header">
                        <h3 class="text-center font-weight-light my-4">Login Toko Buku</h3>
                    </div>
                    <div class="card-body">
                        <form action="/login/auth" method="post">
                            <?php csrf_field() ?>
                            <div class="form-floating mb-3">
                                <input class="form-control <?php if(session('msg')): ?>is-invalid<?php endif ?>" name="email" type="text" placeholder="Email atau Username" />
                                <label for="inputEmail">Email atau Username</label>
                                <div class="invalid-feedback"><?= session('msg') ?></div>
                            </div>
                            <div class="form-floating mb-3">
                                <input class="form-control <?php if(session('msg')): ?>is-invalid<?php endif ?>" name="password" type="password" placeholder="Password" />
                                <label for="inputPassword">Password</label>
                                <div class="invalid-feedback"><?= session('msg') ?></div>
                            </div>
                            <div class="mt-4 mb-0">
                                <div class="d-grid">
                                    <button type="submit" class="btn btn-primary btn-block">Login</button>
                                </div>
                            </div>
                        </form>

                        
                    </div>
                    <div class="card-footer text-center py-3">
                        <div class="small"><a href="login/register">Register</a></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
<?= $this->endSection() ?>

