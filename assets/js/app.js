import React from "react";
import NavBar from "./Components/Navbar/NavBar";
import { Switch, Route } from "react-router-dom";
import HomePage from "./Pages/HomePage/HomePage.page";
import ProfilePage from "./Pages/TeamProfile/ProfilePage.page";
import HrProfiles from "./Pages/HrPage/hrPage.page";
import Footer from "./Components/Footer/Footer.comp";
import Login from "./Pages/Login/Login.page";
import { connect } from "react-redux";
import User from "./Pages/UserProfile/user.page";
import Error from "./Pages/Error/Error";

import { withRouter } from "react-router";
import { setManagerPage } from "./Actions/action";
import { setLoginInfo } from "./thunk/setLoginInfo";

class App extends React.Component {
  componentDidMount() {
    if (localStorage.getItem("jwt") !== null) {
      const data = localStorage.getItem("jwt");
      this.props.onSetLoginInfo(JSON.parse(data));
    }
  }

  render() {
    this.props.location.pathname === "/profiles"
      ? this.props.onSetManagerPage(true)
      : this.props.onSetManagerPage(false);

    return (
      <div className="app">
        <NavBar />
        <Switch>
          <Route exact path="/" component={HomePage} />

          {this.props.roles.includes("ROLE_HEAD") &&
          this.props.logged === true ? (
            <Route path="/profiles" component={ProfilePage} />
          ) : null}

          {this.props.roles.includes("ROLE_ADMIN") &&
          this.props.logged === true ? (
            <Route path="/hrprofiles" component={HrProfiles} />
          ) : null}

          {this.props.logged ? <Route path="/user" component={User} /> : null}

          <Route path="/login" component={Login} />

          <Route component={Error} />
        </Switch>
        <Footer />
      </div>
    );
  }
}

const mapStateToProps = state => ({
  roles: state.user.roles,
  logged: state.user.logged
});

const mapDispatchToProps = dispatch => ({
  onSetManagerPage: profile => dispatch(setManagerPage(profile)),
  onSetLoginInfo: data => dispatch(setLoginInfo(data))
});

export default connect(mapStateToProps, mapDispatchToProps)(withRouter(App));
