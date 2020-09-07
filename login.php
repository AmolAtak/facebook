<?php
require_once "pdo.php";
    session_start();
    if ( isset($_POST["fname"]) && isset($_POST["lname"]) && isset($_POST["sign-email"]) && isset($_POST["sign-password"]) ) {
        unset($_SESSION["sign-email"]);  // Logout current user

        $sql = "INSERT INTO `users` ( name, surname, email, password, day, month, year, gender) 
        VALUES (:name, :surname, :email, :password, :day, :month, :year, :gender)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(array(
          ':name' => $_POST['fname'],
          ':surname' => $_POST['lname'],
          ':email' => $_POST['sign-email'],
          ':password' => $_POST['sign-password'],
          ':day'=> $_POST['birthday-day'],
          ':month'=> $_POST['birthday-month'],
          ':year'=> $_POST['birthday-year'],
          ':gender' => $_POST['gender']
        ));
        
        header('Location: success.php');
        return;
      }

    if (isset($_POST["log-email"]) && isset($_POST["log-password"])){
      unset($_SESSION["log-email"]);

      $email = $_POST["log-email"];
      $stmt = $pdo->prepare("SELECT email, password FROM `users` WHERE email = ?");
      $stmt->bindParam(1, $_POST['log-email'], PDO::PARAM_INT);
      $stmt->execute();
      $row = $stmt->fetch(PDO::FETCH_ASSOC);
      if( ! $row)
      {
          die('nothing found');
      } else {
        $pwd = $row['password'];
        $email = $row['email'];
        if ($_POST["log-email"] != $email){
          $_SESSION['error'] = 'Account does not exist, please sign-up.';
        } else {  
          if ($_POST["log-password"] == $pwd) {
            $_SESSION["log-email"] = $_POST["log-email"]; 
            $_SESSION["success"] = "Logged in.";
            header('Location: app.php');
            return;
          } else {
            $_SESSION['error'] = 'Incorrect Password.';
          }
        } 
      }
    }
?>
<html>
  <head>
    <meta charset="utf-8" />
    <link rel="stylesheet" href="css/styles.css" />
    <meta name="viewport" content="width=device-width, initial scale=1.0" />
    <script
      src="https://kit.fontawesome.com/0b5e068164.js"
      crossorigin="anonymous"
    ></script>
    <title>Facebook - log in or sign up</title>
  </head>

  <body>
    <?php
    if ( isset($_SESSION["error"]) ) {
        echo('<p style="color:red">'.$_SESSION["error"]."</p>\n");
        unset($_SESSION["error"]);
    }
    if ( isset($_SESSION["success"]) ) {
      echo('<p style="color:green">'.$_SESSION["success"]."</p>\n");
      unset($_SESSION["success"]);
  }  
?>

    <div class="main" id="main1">
      <div class="one">
        <div>
          <h1 class="facebook-name">facebook</h1>
          <p class="slogan">
            Facebook helps you connect and share with the people in your life.
          </p>
        </div>
      </div>
      <div class="two">
        <div class="two-main">
          <form method="post" autocomplete="off">
            <div>
              <input
                class="email"
                type="text"
                name="log-email"
                placeholder="Email address or phone number"
                required
              />
            </div>
            <div>
              <input
                class="password"
                type="password"
                name="log-password"
                placeholder="Password"
                required
              />
            </div>
            <div>
              <input
                class="log-in"
                type="submit"
                name="log-in"
                value="Log In"
              />
            </div>
            <div class="forgotten">
              <a class="forgotten-account" href="">Forgotten account?</a>
            </div>
            <div class="hr"></div>
            <div class="account">
              <a class="new-account" onclick="signUp()">Create New Account</a>
            </div>
          </form>
        </div>
        <div class="create-page">
          <p>
            <a href=""><b>Create a Page</b></a> for a celebrity, brand or
            business.
          </p>
        </div>
      </div>
    </div>
    <div id="sign-up">
      <div class="sign-up">
        <div class="sign-up-container">
          <div class="three">
            <h1 class="sign-up-name">Sign Up</h1>
            <p class="its-quick">It's quick and easy.</p>
          </div>
          <div class="four">
            <a href="">
              <i
                onclick="closeSignUp()"
                style="color: rgba(0, 0, 0, 0.6); font-size: 150%;"
                class="fas fa-times"
              ></i
            ></a>
          </div>
        </div>
        <div class="hr hr1"><!--Horizontal line--></div>
        <div>
          <form method="post" class="signup-form" autocomplete="off">
            <div>
              <div class="three">
                <input
                  class="email fname"
                  type="text"
                  name="fname"
                  placeholder="First name"
                  required
                />
              </div>
              <div class="three">
                <input
                  class="email fname fname2"
                  type="text"
                  name="lname"
                  placeholder="Surname"
                  required
                />
              </div>
            </div>
            <div>
              <input
                class="email fname s-password"
                type="text"
                name="sign-email"
                placeholder="Mobile number or email address"
                required
              />
            </div>
            <div>
              <input
                class="email fname s-password"
                type="text"
                name="sign-password"
                placeholder="New password"
                required
              />
            </div>
            <div>
              <div class="dob">Date of birth</div>
              <div class="question" onclick="questionPopUp()">
                <a><i class="fas fa-question-circle"></i></a>
              </div>
            </div>
            <div class="box arrow-right" id="question">
              <b>Providing your date of birth</b> helps make sure that you get
              the right Facebook experience for your age. If you want to change
              who sees this, go to the About section of your Profile. For more
              details, please visit our <a class="a" href="#">Data Policy</a>.
              <div class="hr2"></div>
              <div>
                <a class="close" onclick="questionClose()" href="#">Close</a>
              </div>
            </div>
            <div class="dob-main">
              <div class="day">
                <select name="birthday-day" id="day" title="Day" required>
                  <option value="">Day</option>
                  <option value="1">1</option>
                  <option value="2">2</option>
                  <option value="3">3</option>
                  <option value="4">4</option>
                  <option value="5">5</option>
                  <option value="6">6</option>
                  <option value="7">7</option>
                  <option value="8">8</option>
                  <option value="9">9</option>
                  <option value="10">10</option>
                  <option value="11">11</option>
                  <option value="12">12</option>
                  <option value="13">13</option>
                  <option value="14">14</option>
                  <option value="15">15</option>
                  <option value="16">16</option>
                  <option value="17">17</option>
                  <option value="18">18</option>
                  <option value="19">19</option>
                  <option value="20">20</option>
                  <option value="21">21</option>
                  <option value="22">22</option>
                  <option value="23">23</option>
                  <option value="24">24</option>
                  <option value="25">25</option>
                  <option value="26">26</option>
                  <option value="27">27</option>
                  <option value="28">28</option>
                  <option value="29">29</option>
                  <option value="30">30</option>
                  <option value="31">31</option>
                </select>
              </div>
              <div class="month m1">
                <select name="birthday-month" id="month" title="Month" required>
                  <option value="">Month</option>
                  <option value="jan">Jan</option>
                  <option value="feb">Feb</option>
                  <option value="mar">Mar</option>
                  <option value="apr">Apr</option>
                  <option value="may">May</option>
                  <option value="jun">Jun</option>
                  <option value="jul">Jul</option>
                  <option value="aug">Aug</option>
                  <option value="sep">Sep</option>
                  <option value="oct">Oct</option>
                  <option value="nov">Nov</option>
                  <option value="dec">Dec</option>
                </select>
              </div>
              <div class="year m1">
                <select name="birthday-year" id="year" title="Year" required>
                  <option value="">Year</option>
                  <option value="2020">2020</option>
                  <option value="2019">2019</option>
                  <option value="2018">2018</option>
                  <option value="2017">2017</option>
                  <option value="2016">2016</option>
                  <option value="2015">2015</option>
                  <option value="2014">2014</option>
                  <option value="2013">2013</option>
                  <option value="2012">2012</option>
                  <option value="2011">2011</option>
                  <option value="2010">2010</option>
                  <option value="2009">2009</option>
                  <option value="2008">2008</option>
                  <option value="2007">2007</option>
                  <option value="2006">2006</option>
                  <option value="2005">2005</option>
                  <option value="2004">2004</option>
                  <option value="2003">2003</option>
                  <option value="2002">2002</option>
                  <option value="2001">2001</option>
                  <option value="2000">2000</option>
                  <option value="1999">1999</option>
                  <option value="1998">1998</option>
                  <option value="1997">1997</option>
                  <option value="1996">1996</option>
                  <option value="1995">1995</option>
                  <option value="1994">1994</option>
                  <option value="1993">1993</option>
                  <option value="1992">1992</option>
                  <option value="1991">1991</option>
                  <option value="1990">1990</option>
                  <option value="1989">1989</option>
                  <option value="1988">1988</option>
                  <option value="1987">1987</option>
                  <option value="1986">1986</option>
                  <option value="1985">1985</option>
                  <option value="1984">1984</option>
                  <option value="1983">1983</option>
                  <option value="1982">1982</option>
                  <option value="1981">1981</option>
                  <option value="1980">1980</option>
                  <option value="1979">1979</option>
                  <option value="1978">1978</option>
                  <option value="1977">1977</option>
                  <option value="1976">1976</option>
                  <option value="1975">1975</option>
                  <option value="1974">1974</option>
                  <option value="1973">1973</option>
                  <option value="1972">1972</option>
                  <option value="1971">1971</option>
                  <option value="1970">1970</option>
                  <option value="1969">1969</option>
                  <option value="1968">1968</option>
                  <option value="1967">1967</option>
                  <option value="1966">1966</option>
                  <option value="1965">1965</option>
                  <option value="1964">1964</option>
                  <option value="1963">1963</option>
                  <option value="1962">1962</option>
                  <option value="1961">1961</option>
                  <option value="1960">1960</option>
                  <option value="1959">1959</option>
                  <option value="1958">1958</option>
                  <option value="1957">1957</option>
                  <option value="1956">1956</option>
                  <option value="1955">1955</option>
                  <option value="1954">1954</option>
                  <option value="1953">1953</option>
                  <option value="1952">1952</option>
                  <option value="1951">1951</option>
                  <option value="1950">1950</option>
                  <option value="1949">1949</option>
                  <option value="1948">1948</option>
                  <option value="1947">1947</option>
                  <option value="1946">1946</option>
                  <option value="1945">1945</option>
                  <option value="1944">1944</option>
                  <option value="1943">1943</option>
                  <option value="1942">1942</option>
                  <option value="1941">1941</option>
                  <option value="1940">1940</option>
                  <option value="1939">1939</option>
                  <option value="1938">1938</option>
                  <option value="1937">1937</option>
                  <option value="1936">1936</option>
                  <option value="1935">1935</option>
                  <option value="1934">1934</option>
                  <option value="1333">1333</option>
                  <option value="1932">1932</option>
                  <option value="1931">1931</option>
                  <option value="1930">1930</option>
                  <option value="1929">1929</option>
                  <option value="1928">1928</option>
                  <option value="1927">1927</option>
                  <option value="1926">1926</option>
                  <option value="1925">1925</option>
                  <option value="1924">1924</option>
                  <option value="1923">1923</option>
                  <option value="1922">1922</option>
                  <option value="1921">1921</option>
                  <option value="1920">1920</option>
                </select>
              </div>
            </div>
            <div class="gender-main">
              <div class="gender">Gender</div>
              <div class="question">
                <a
                  ><i
                    onclick="genderQuestion()"
                    class="fas fa-question-circle"
                  ></i
                ></a>
              </div>
            </div>
            <div class="gender-box arrow-right" id="gender-question">
              You can change who sees your gender on your profile later. Select
              Custom to choose another gender, or if you'd rather not say.
              <div class="hr2"></div>
              <div>
                <a class="close" onclick="genderQuestionClose()" href="#"
                  >Close</a
                >
              </div>
            </div>
            <div>
              <div class="female">
                <label class="label1" for="female">Female</label>
                <input
                  type="radio"
                  name="gender"
                  id="female"
                  value="Female"
                  required
                />
              </div>
              <div class="male">
                <label class="label2" for="male">Male</label>
                <input
                  type="radio"
                  name="gender"
                  id="male"
                  value="Male"
                  required
                />
              </div>
              <div class="custom">
                <label class="label1" for="custom">Custom</label>
                <input
                  type="radio"
                  name="gender"
                  id="custom"
                  value="Custom"
                  required
                />
              </div>
            </div>
            <div>
              <p class="add-info">
                By clicking Sign Up, you agree to our
                <a class="a" href="#">Terms</a>,
                <a class="a" href="#">Data Policy</a> and
                <a class="a" href="#">Cookie Policy</a>. You may receive SMS
                notifications from us and can opt out at any time.
              </p>
            </div>
            <div>
              <button class="new-signUp">Sign Up</button>
            </div>
          </form>
        </div>
      </div>
    </div>

    <script src="js/script.js"></script>
  </body>
</html>
