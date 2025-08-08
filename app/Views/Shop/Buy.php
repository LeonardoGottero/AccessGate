<?= $this->extend('Layouts/Form') ?>
<?= $this->section('title') ?>
    Comprar <?= $Product['name'] ?>
<?= $this->endSection() ?>
<?= $this->section('content') ?>
    <button class="back-button" onClick="history.back();">
        <span>« Volver</span>
    </button>
    <div class="card">
        <img src="<?= base_url('Images/'.$Product['image']) ?>" class="product-img-buy">
        <h1>Esta comprando <?= $Product['name']?></h1>
        <h2>Precio: USD <?= $Product['price']?></h2>
        <h1>Ingrese sus datos</h1>
        <form action="<?= base_url('/Paypal/Create/'.$Product['ProductId']) ?>" method="POST">
            <input type="hidden" name="<?= csrf_token() ?>" value="<?= csrf_hash() ?>">
            <div class="form-control">
                <input type="text" class="input input-alt" id="completename" name="completename" placeholder="Nombre completo" required>
                <span class="input-border input-border-alt"></span>
            </div>
            <div class="form-control">
                <input type="text" class="input input-alt" id="address" name="address" placeholder="Dirección" required>
                <span class="input-border input-border-alt"></span>
            </div>
            <div class="form-control">
                <input type="text" class="input input-alt" id="phone" name="phone" placeholder="Número de teléfono" required>
                <span class="input-border input-border-alt"></span>
            </div>
            <div class="form-control">
                <select class="input input-alt" id="province" name="province" required>
                    <option  value="">Seleccione una provincia</option>
                    <?php foreach ($provinces as $province): ?>
                        <option value="<?= $province['ProvinceId'] ?>"><?= $province['province'] ?></option>
                    <?php endforeach; ?>
                </select>
                <span class="input-border input-border-alt"></span>
            </div>
            <div class="form-control">
                <select class="input input-alt" id="city" name="city" required>
                    <option value="">Seleccione una ciudad</option>
                </select>
                <span class="input-border input-border-alt"></span>
            </div>

            <button type="submit" class="button">Pagar con PayPal</button>
        </form>
    </div>
<?= $this->endSection() ?>
<?= $this->section('scripts') ?>
    <script>
        document.getElementById('province').addEventListener('change', function() {
            var provinceId = this.value;
            var citySelect = document.getElementById('city');
            citySelect.innerHTML = '<option value="">Cargando ciudades...</option>';
            if (provinceId) {
                fetch('<?= base_url('/Shop/getCitiesByProvince/') ?>' + provinceId)
                    .then(response => response.json())
                    .then(data => {
                        citySelect.innerHTML = '<option value="">Seleccione una ciudad</option>';
                        data.forEach(city => {
                            var option = document.createElement('option');
                            option.value = city.CityId;
                            option.textContent = city.city;
                            citySelect.appendChild(option);
                        });
                    })
                    .catch(error => {
                        citySelect.innerHTML = '<option value="">Error al cargar ciudades</option>';
                        console.error('Error:', error);
                    });
            } else {
                citySelect.innerHTML = '<option value="">Seleccione una ciudad</option>';
            }
        });
    </script>
<?= $this->endSection() ?>