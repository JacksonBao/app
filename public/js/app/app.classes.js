class Cookie {
  constructor() {
  }

  static setCookie(cname, cvalue, exdays) {
      var d = new Date();
      if(!exdays){exdays = 1;}
      d.setTime(d.getTime() + (exdays * 24 * 60 * 60 * 1000));
      var expires = "expires=" + d.toUTCString();
      // document.cookie = cname + "=" + cvalue + ";domain=.njofa.com;" + expires + ";path=/";
      document.cookie = cname + "=" + cvalue + ";domain=.thanosapi.dv;" + expires + ";path=/";
  }

  static getCookie(cname) {
      var name = cname + "=";
      var ca = document.cookie.split(';');
      for (var i = 0; i < ca.length; i++) {
          var c = ca[i];
          while (c.charAt(0) == ' ') {
              c = c.substring(1);
          }
          if (c.indexOf(name) == 0) {
              return c.substring(name.length, c.length);
          }
      }
      return "";
  }



  static checkCookie(cname) {
      var exist = this.getCookie(cname);
      if (exist != "") {
          return true;
      } else {
          return false;
      }
  }


}


class Storage {
  constructor() {
  }

  // storage functions
  static getStorage(name) {
      if (typeof (Storage) !== 'undefined') {
          if (localStorage.getItem(name)) {
              return localStorage.getItem(name);
          } else {
              return false;
          }
      } else {
          return false;
      }
  }

  static checkStorage(name) {
      if (typeof (Storage) !== 'undefined') {
          if (localStorage.getItem(name)) {
              return true;
          } else {
              return false;
          }
      } else {
          return false;
      }
  }

  static setStorage(name, value) {
      if (typeof (Storage) !== 'undefined') {
          localStorage.setItem(name, value);
      }
  }

  static deleteStorage(name) {
      if (typeof (Storage) !== 'undefined') {
          localStorage.removeItem(name);
      }
  }
  // end storrage

}

class UserLocation {

  constructor() {
          if(Cookie.checkCookie('user_location') == false){
             $.ajax({
                url: "https://geolocation-db.com/jsonp",
                jsonpCallback: "callback",
                dataType: "jsonp",
                success: function(location) {
                  var locationString = JSON.stringify(location);
                  Cookie.setCookie('user_location', locationString, 2);
                }
              });
              this.setLocation();
            }else {
              this.setLocation();
            }
  }

  setLocation(){
      if(Cookie.checkCookie('user_location') == true) {
        var location = JSON.parse(Cookie.getCookie('user_location'));
        this.location = location; 
      }
  }

  getCountrCode(){
    return this.location.country_code;
  }
  getCountry(){
    return this.location.country_name;
  }
  getState(){
    return this.location.state;
  }
  getCity(){
    return this.location.city;
  }
  getPostal(){
    return this.location.postal;
  }
  getLatitude(){
    return this.location.latitude;
  }
  getLongitude(){
    return this.location.latitude;
  }
  getIp(){
    return this.location.IPv4
  }

}
