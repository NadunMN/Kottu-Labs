<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>myprofile</title>
  <link rel="stylesheet" href="/CSS/userprofile.css">
</head>
<body>

<div class="personal-information">
            <!-- order list -->
            <div class="personal-information-container">
                <h2>Personal Information</h2>
            </div>

            <hr style="border: 0.5px solid #ccc; width: 100%; margin-top: 20px; opacity:0.5; width: 90%;">



            <form class="personal-information-form-wrapper" id="update-form" action="">
              <div class="personal-information-form-information">
                <div class="personal-information-container-first">
                  <div class="personal-information-name">
                    <div>
                      <label for="firstname">Frist Name</label>
                      <input type="text" id="fname" name="firstname" placeholder="Frist Name" required>
                    </div>

                    <div>
                      <label for="lastname">Last Name</label>
                      <input type="text" id="lname" name="lastname" placeholder="Last Name" required>
                    </div>

                  </div>


                  <div class="personal-information-name">
                    <div>
                    <label for="mobile_number">Mobile Number</label>
                    <input type="tel" id="phone" name="mobile_number" placeholder="Mobile Number" required>

                    </div>
                  </div>


                  <div class="personal-information-name">
                    <div>
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email"  placeholder="Enter your email!">

                    </div>
                  </div>


                  <div class="personal-information-name">
                    <div>
                      <label for="created_at">Account Creation</label>
                      <input type="text" id="accountc" name="created_at" value="" disabled>
                    </div>

                  </div>

                  


                </div>

                <div class="personal-information-container-second">

                <div class="personal-information-name">
                    <div>
                      <label for="date_of_birth">Date of Birth</label>
                      <input type="date" id="date" name="date_of_birth" placeholder="Enter your Date of Birth">

                    </div>

                    <div>
                    <label for="gender">Gender</label>
                    <select id="gender" name="gender">
                        <option value="">Select Gender</option>
                        <option value="male">Male</option>
                        <option value="female">Female</option>
                        <option value="other">Other</option>
                    </select>
                    </div>

                  </div>

                  <div class="personal-information-name">
                  <div>
                      <label for="address">Address</label>
                      <input type="text" id="address" name="address" placeholder="Enter your Adress!.">
                    </div>
                  </div>


                  <div class="personal-information-name">
                  <div>
                    <label for="nationality">Nationality</label>
                        <select id="nationality" name="nationality">
                          <option value="">Select Nationality</option>
                          <option value="Sri Lanka">Sri Lanka</option>
                          <option value="other">Other</option>
                        </select>
                    </div>
                  </div>

                  


                </div>

              </div>

              <div class="personal-information-form-button">
                <div>
                <button id="save" type="submit">Save Change</button>
                <button id="cancel" type="" disabled>Cancel</button>

                </div>

                <!-- <button id="delete">Delete Account</button> -->
              </div>
            </form>

        </div>


<div class="personal-information">
            <!-- order list -->
            <div class="personal-information-container danger-zone">
                <h2>Danger Zone</h2>
                <h5>Delete your account</h5>
            </div>

            <hr style="border: 0.5px solid #ccc; width: 100%; margin: 20px; opacity:0.5; width: 90%;">

            <div class="Danger-zone-body">

              <div class="Danger-zone-body-first">
                <p>Are you sure you want to delete your account?
                Once you delete your account, there is no going back. Please be certain.</p>
              </div>

              <div class="Danger-zone-body-second">
                <button id="delete">Delete Account</button>
              </div>

            </div>


        </div>

<script>

  fetch('/user/data')
          .then(response => response.json())
          .then(data => {
              if (data.error) {
                  console.error(data.error);
              } else {
                  document.getElementById('gender').value = data.gender;
                  document.getElementById('nationality').value = data.nationality;
                  document.getElementById('accountc').value = data.created_at;
                  document.getElementById('date').value = data.date_of_birth;
                  document.getElementById('address').value = data.address;

              }
          })
          .catch(error => console.error('Error fetching user data:', error));
</script>

<script src="/JavaScript/profile.js"></script>

</body>
</html>