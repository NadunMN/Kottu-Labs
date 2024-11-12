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



            <form class="personal-information-form-wrapper" action="">
              <div class="personal-information-form-information">
                <div class="personal-information-container-first">
                  <div class="personal-information-name">
                    <div>
                      <label for="fname">Frist Name</label>
                      <input type="text" id="fname" name="fname" placeholder="">
                    </div>

                    <div>
                      <label for="lname">Last Name</label>
                      <input type="text" id="lname" name="lname" placeholder="">
                    </div>

                  </div>


                  <div class="personal-information-name">
                    <div>
                    <label for="phone">Mobile Number</label>
                    <input type="tel" id="phone" name="phone" placeholder="Enter Your Phone Number">

                    </div>
                  </div>


                  <div class="personal-information-name">
                    <div>
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email"  placeholder="nadunmadusanka@gmail.com">

                    </div>
                  </div>

                  <div class="personal-information-name">
                    <div>
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password"  placeholder="api meka krnna one 123" required>

                    </div>
                  </div>


                </div>

                <div class="personal-information-container-second">

                <div class="personal-information-name">
                    <div>
                      <label for="date">Date of Birth</label>
                      <input type="date" id="date" name="date" value="00-00-00">
                    </div>

                    <div>
                    <label for="gender">Gender</label>
                        <select id="gender" name="gender" required>
                          <option value="">Select Gender</option>
                          <option value="male">Male</option>
                          <option value="female">Female</option>
                          <option value="other">Other</option>
                        </select>
                    </div>

                  </div>

                  <div class="personal-information-name">
                  <div>
                      <label for="adress">Adress</label>
                      <input type="text" id="adress" name="adress" placeholder="Enter your Adress..">
                    </div>
                  </div>


                  <div class="personal-information-name">
                  <div>
                    <label for="nationality">Nationality</label>
                        <select id="nationality" name="nationality" required>
                          <option value="">Select Nationality</option>
                          <option value="male">Sri Lanka</option>
                          <option value="other">Other</option>
                        </select>
                    </div>
                  </div>

                  <div class="personal-information-name">
                    <div>
                      <label for="accountc">Account Creation</label>
                      <input type="date" id="accountc" name="accountc" placeholder="2024/10/23" disabled>
                    </div>

                  </div>


                </div>

              </div>

              <div class="personal-information-form-button">
                <div>
                <button id="save" type="submit">Save Change</button>
                <button id="cancel" type="submit">Cancel</button>

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

<script src="/JavaScript/profile.js"></script>

</body>
</html>