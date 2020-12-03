class ValidateForm {
  constructor() {
    this.hasError = false;
    this.inputs = [];
    this.sanitize = {
      string: {
        'country': { 'min': 3, 'max': 3, null: false, message: 'This is an error', id: '_country' }
      },
      int: {},
      object: {},
      email: {}
    };
    this.errorMessages = '';
    this.errorId = '';
  }

  // preg replace to leave string
  getString(val = '') {
    var ret =  val.replace(/[^a-zA-Z0-9 \_\-\,\(\)\!\=\.\@]/gim, '');
    return ret;
  }
  getInt(val) {
    try {
      
        if (val > 0) { return val; } else { 
        return val.replace(/[^0-9.]/g, '');
        }
     
    } catch (e) {
      return '';
    }
  }
  getEmail(val) {
    var exp = val.split('@');
    if (exp.length == 2) {
      var expdot = val.split('.');
      if (expdot.length > 1) {
        return val;
      }
    }
    return '';

  }
  // preg replace to leave string

  sanitizeForm() {
    for (var ix = 0; ix < this.inputs.length; ix++) {
      if (this.hasError == true) { break };
      var input = this.inputs[ix];
      var name = input.name;
      var value = input.value;
      var strict = input.strict || false;
      // console.log

      var meth = input.meth || 'string';
      if (meth == 'string') {
        if (strict == true) {
          this.inputs[ix].value = this.getString(value);
        } else {
          this.inputs[ix].value = value;
        }
      } else if (meth == 'email') {
        if (strict == true) {
          this.inputs[ix].value = this.getEmail(value);
        } else {
          this.inputs[ix].value = value;
        }
      } else if (meth == 'int') {
        if (strict == true) {
          this.inputs[ix].value = this.getInt(value);
        } else {
          this.inputs[ix].value = value;
        }
      } else if (meth == 'object') {
        this.inputs[ix].value = value;
      }

      var checked = this.checkCondition(this.inputs[ix].value, input);
      if (checked == false) {
        this.hasError = true;
        break;
      }
    }

    if (this.hasError == false) {
      return this.assembleInput();
    } else {
      return false;
    }

  }

  checkCondition(value, obj) {
    
    var objKeys = Object.keys(obj);
    if (objKeys.indexOf('null') >= 0 && obj.null == true) {
      return true;
    } else {
      if (objKeys.indexOf('min') >= 0 && obj.min != 0 && value.length < obj.min) {
        this.errorMessages = obj.message || 'Invalid input length.';
        this.errorId = obj.id || '';
        return false;
      }
      if (objKeys.indexOf('max') >= 0 && obj.max != 0 && value.length > obj.max) {
        this.errorMessages = obj.message || 'Invalid input length.';
        this.errorId = obj.id || '';
        return false;
      }
    }
    return true;
  }

  assembleInput() {
    var results = {};
    for (var i = 0; i < this.inputs.length; i++) {
      var obj = this.inputs[i];
      results[obj.name] = obj.value;
    }
    return results;
  }

}
