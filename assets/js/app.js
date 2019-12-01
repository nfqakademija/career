import React from "react";
import NavBar from "./Components/Navbar/NavBar";
import { Switch, Route } from "react-router-dom";
import HomePage from "./Pages/HomePage/HomePage.page";
import ProfilePage from "./Pages/ProfilePage/ProfilePage.page";
import HrProfiles from "./Pages/HrPage/hrPage.page";
import Footer from "./Components/Footer/Footer.comp";
import Login from "./Pages/Login/Login.page";
import { connect } from "react-redux";
// import Error from "./Pages/Error/Error";

class App extends React.Component {
  render() {
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

          <Route path="/login" component={Login} />
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

export default connect(mapStateToProps, null)(App);
