import React from "react";
import "./Login.style.scss";
import { connect } from "react-redux";
import { setEmail, setLogged, setPassword } from "../../Actions/action";
import Axios from "axios";
import { Redirect } from "react-router-dom";
import { setLoginInfo } from "../../thunk/setLoginInfo";

class Login extends React.Component {
  change = e => {
    if (e.target.name === "email") {
      this.props.onSetEmail(e.target.value);
    }

    if (e.target.name === "password") {
      this.props.onSetPassword(e.target.value);
    }
  };

  submit = e => {
    e.preventDefault();

    Axios.post("/api/login_check", {
      username: this.props.email,
      password: this.props.password
    })
      .then(response => {
        if (response.data !== 401 && response.data !== 404) {
          this.props.onSetLoginInfo(response.data);
          localStorage.setItem("jwt", JSON.stringify(response.data));
          localStorage.setItem('email', JSON.stringify(this.props.email));
        } else {
          alert("Login Failed");
        }
      })
      .catch(function(error) {
        console.log(error);
      });
  };

  render() {
    return (
      <div className="login">
        <form onSubmit={this.submit}>
          <div className="form-group">
            <label htmlFor="exampleInputEmail1">Email address</label>
            <input
              type="email"
              className="form-control"
              id="exampleInputEmail1"
              aria-describedby="emailHelp"
              placeholder="Enter email"
              required
              name="email"
              value={this.props.email}
              onChange={this.change}
            />
          </div>
          <div className="form-group">
            <label htmlFor="exampleInputPassword1">Password</label>
            <input
              type="password"
              className="form-control"
              id="exampleInputPassword1"
              placeholder="Password"
              required
              name="password"
              onChange={this.change}
            />
          </div>
          <button type="submit" className="btn btn-primary">
            Submit
          </button>
        </form>
        {this.props.logged ? <Redirect to="/" /> : null}
      </div>
    );
  }
}

const mapStateToProps = state => ({
  email: state.user.email,
  password: state.user.password,
  logged: state.user.logged
});

const mapDispatchToProps = dispatch => ({
  onSetEmail: email => dispatch(setEmail(email)),
  onSetPassword: password => dispatch(setPassword(password)),
  onSetLogged: logged => dispatch(setLogged(logged)),
  onSetLoginInfo: data => dispatch(setLoginInfo(data))
});

export default connect(mapStateToProps, mapDispatchToProps)(Login);
