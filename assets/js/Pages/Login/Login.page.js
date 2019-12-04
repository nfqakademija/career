import React from "react";
import "./Login.style.scss";
import { connect } from "react-redux";
import {
  setEmail,
  setFullName,
  setUserId,
  setTitle,
  setCareerFormId,
  setProfessionId,
  setRoles,
  setLogged,
  setTeams
} from "../../Actions/action";
import Axios from "axios";
import { Redirect } from 'react-router-dom';

class Login extends React.Component {
  constructor() {
    super();

    this.state = {
      password: "",
    };
  }

  change = e => {
    if (e.target.name === "email") {
      this.props.onSetEmail(e.target.value);
    }

    if (e.target.name === "password") {
      this.setState({ password: e.target.value });
    }
  };

  submit = e => {
    e.preventDefault();

    const {
      onSetRoles,
      onSetCareerFormId,
      onSetFullName,
      onSetUserId,
      onSetProfessionId,
      onSetTitle,
      onSetLogged,
      onSetTeams
    } = this.props;

    Axios.post("/api/users/logins", {
      email: this.props.email,
      password: this.state.password
    })
      .then(response => {
        if (response.data !== 401 && response.data !== 404) {
          // onSetCareerFormId(response.data.careerFormId);
          onSetFullName(response.data.firstName + " " + response.data.lastName);
          onSetUserId(response.data.id);
          onSetProfessionId(response.data.professionId);
          onSetRoles(response.data.roles);
          onSetTitle(response.data.professionTitle);
          onSetLogged(!this.props.logged);
          onSetTeams(response.data.teams)
          console.log("Success");
        } else {
          console.log("Fail");
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
        {this.props.logged?<Redirect to="/" />: null}
      </div>
    );
  }
}

const mapStateToProps = state => ({
  email: state.user.email,
  logged: state.user.logged
});

const mapDispatchToProps = dispatch => ({
  onSetEmail: email => dispatch(setEmail(email)),
  onSetFullName: name => dispatch(setFullName(name)),
  onSetUserId: userId => dispatch(setUserId(userId)),
  onSetTitle: title => dispatch(setTitle(title)),
  // onSetCareerFormId: formId => dispatch(setCareerFormId(formId)),
  onSetProfessionId: professionId => dispatch(setProfessionId(professionId)),
  onSetRoles: roles => dispatch(setRoles(roles)),
  onSetLogged: logged => dispatch(setLogged(logged)),
  onSetTeams: teams => dispatch(setTeams(teams))
});

export default connect(mapStateToProps, mapDispatchToProps)(Login);
