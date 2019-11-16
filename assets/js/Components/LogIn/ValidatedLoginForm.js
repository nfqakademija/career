import React from "react";
import "./logIn.style.scss";
import { connect } from "react-redux";
import { setPassword, setUsername, isLoggedIn } from "../../Actions/action";
// import { Redirect } from "react-router-dom";

class ValidatedLoginForm extends React.Component {
  handleUserChange = e => {
    this.props.onSetUsername(e.target.value);
  };

  handlePassChange = e => {
    this.props.onSetPassword(e.target.value);
  };

  handleSubmit = e => {
    e.preventDefault();
    if (this.props.username === "123" && this.props.password === "123") {
      this.props.onSetLoggedIn(!this.props.logged);

      // <Redirect to="/profiles" />;
    }
  };

  render() {
    // NOTE: I use data-attributes for easier E2E testing
    // but you don't need to target those (any css-selector will work)

    return (
      <div className="Login">
         <form onSubmit={this.handleSubmit}>
          <label>User Name</label>
          <input
            type="text"
            data-test="username"
            value={this.props.username}
            onChange={this.handleUserChange}
          />

          <label>Password</label>
          <input
            type="password"
            data-test="password"
            value={this.props.password}
            onChange={e => this.props.onSetPassword(e.target.value)}
          />

          <input type="submit" value="Log In" data-test="submit" />
        </form> 
        
        <h5>username: 123 | password: 123</h5>
        {/* {console.log(!this.props.logged)} */}
      </div>
    );
  }
}

const mapStateToProps = state => ({
  username: state.username.username,
  password: state.password.password,
  logged: state.logged.logged
});
const mapDispatchToProps = dispatch => ({
  onSetUsername: username => dispatch(setUsername(username)),
  onSetPassword: password => dispatch(setPassword(password)),
  onSetLoggedIn: logged => dispatch(isLoggedIn(logged))
});

export default connect(mapStateToProps, mapDispatchToProps)(ValidatedLoginForm);
