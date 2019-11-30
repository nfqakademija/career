import React from "react";
import './Login.style.scss';

class Login extends React.Component {
  render() {
    return (
        <div className="login">
            <form>
                <label htmlFor="email">E-mail: </label>
                <input type="email" name="email"/>
                <label htmlFor="password">Password: </label>
                <input type="password" name="password"/>
            </form>
        </div>
    )
  }
}

export default Login;
