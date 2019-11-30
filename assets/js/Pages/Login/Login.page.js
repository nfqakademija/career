import React from "react";
import "./Login.style.scss";
import { connect } from "react-redux";
import { setEmail } from "../../Actions/action";

class Login extends React.Component {
  constructor() {
    super();

    this.state = {
      password: ''
    };
  }

  change = e => {
    if(e.target.name === 'email'){
      this.props.onSetEmail(e.target.value)
    }

    if(e.target.name === 'password'){
      this.setState({password: e.target.value})
    }
  };

  submit = e => {
    e.preventDefault();

    
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
              value={this.state.password}
              onChange={this.change}
            />
          </div>
          <button type="submit" className="btn btn-primary">
            Submit
          </button>
        </form>
      </div>
    );
  }
}

const mapStateToProps = state => ({
  email: state.email.email
});

const mapDispatchToProps = dispatch => ({
  onSetEmail: email => dispatch(setEmail(email))
});

export default connect(mapStateToProps, mapDispatchToProps)(Login);
