<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Address Form</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .container {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            max-width: 500px;
            width: 100%;
        }
        h2 {
            text-align: center;
            color: #8b0000;
            margin-bottom: 20px;
        }
        .form-group {
            margin-bottom: 15px;
        }
        .form-group label {
            display: block;
            margin-bottom: 5px;
            color: #333;
        }
        .form-group input, .form-group textarea, .form-group select {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }
        .form-group textarea {
            resize: none;
        }
        .form-group input:focus, .form-group textarea:focus, .form-group select:focus {
            border-color: #8b0000;
            outline: none;
        }
        button {
            width: 100%;
            padding: 10px;
            background-color: #8b0000;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        button:hover {
            background-color: #800000;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Address Form</h2>
        <form action="save_address.php" method="POST">
            <div class="form-group">
                <label for="name">Recipient Name</label>
                <input type="text" id="name" name="name" required>
            </div>
            <div class="form-group">
                <label for="phone">Phone Number</label>
                <input type="text" id="phone" name="phone" required>
            </div>
            <div class="form-group">
                <label for="province">Province</label>
                <select id="province" name="province" required>
                    <option value="">Select Province</option>
                </select>
            </div>
            <div class="form-group">
                <label for="city">City</label>
                <select id="city" name="city" required>
                    <option value="">Select City</option>
                </select>
            </div>
            <div class="form-group">
                <label for="subdistrict">Subdistrict</label>
                <select id="subdistrict" name="subdistrict" required>
                    <option value="">Select Subdistrict</option>
                </select>
            </div>
            <div class="form-group">
                <label for="village">Village</label>
                <select id="village" name="village" required>
                    <option value="">Select Village</option>
                </select>
            </div>
            <div class="form-group">
                <label for="postal_code">Postal Code</label>
                <select id="postal_code" name="postal_code" required>
                    <option value="">Select Postal Code</option>
                </select>
            </div>
            <div class="form-group">
                <label for="address">Detailed Address</label>
                <textarea id="address" name="address" rows="4" required></textarea>
            </div>
            <input type="hidden" name="user_id" value="1"> <!-- Adjust with the logged-in user's ID -->
            <button type="submit">Save Address</button>
        </form>
    </div>

    <script>
        // Fetch provinces
        fetch('https://api.rajaongkir.com/starter/province', {
            method: 'GET',
            headers: {
                'key': 'YOUR_API_KEY'
            }
        })
        .then(response => response.json())
        .then(data => {
            const provinces = data.rajaongkir.results;
            const provinceSelect = document.getElementById('province');
            provinces.forEach(province => {
                const option = document.createElement('option');
                option.value = province.province_id;
                option.textContent = province.province;
                provinceSelect.appendChild(option);
            });
        });

        // Fetch cities based on selected province
        document.getElementById('province').addEventListener('change', function() {
            const provinceId = this.value;
            fetch(`https://api.rajaongkir.com/starter/city?province=${provinceId}`, {
                method: 'GET',
                headers: {
                    'key': 'YOUR_API_KEY'
                }
            })
            .then(response => response.json())
            .then(data => {
                const cities = data.rajaongkir.results;
                const citySelect = document.getElementById('city');
                citySelect.innerHTML = '<option value="">Select City</option>';
                cities.forEach(city => {
                    const option = document.createElement('option');
                    option.value = city.city_id;
                    option.textContent = city.city_name;
                    citySelect.appendChild(option);
                });
            });
        });

        // Fetch subdistricts based on selected city
        document.getElementById('city').addEventListener('change', function() {
            const cityId = this.value;
            fetch(`https://api.rajaongkir.com/starter/subdistrict?city=${cityId}`, {
                method: 'GET',
                headers: {
                    'key': 'YOUR_API_KEY'
                }
            })
            .then(response => response.json())
            .then(data => {
                const subdistricts = data.rajaongkir.results;
                const subdistrictSelect = document.getElementById('subdistrict');
                subdistrictSelect.innerHTML = '<option value="">Select Subdistrict</option>';
                subdistricts.forEach(subdistrict => {
                    const option = document.createElement('option');
                    option.value = subdistrict.subdistrict_id;
                    option.textContent = subdistrict.subdistrict_name;
                    subdistrictSelect.appendChild(option);
                });
            });
        });

        // Fetch villages based on selected subdistrict
        document.getElementById('subdistrict').addEventListener('change', function() {
            const subdistrictId = this.value;
            // Add your logic to fetch villages here
        });

        // Fetch postal codes based on selected village
        document.getElementById('village').addEventListener('change', function() {
            const villageId = this.value;
            // Add your logic to fetch postal codes here
        });
    </script>
</body>
</html>
