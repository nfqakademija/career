import React from "react";
import NavBar from "./Components/Navbar/NavBar";
import { Switch, Route } from "react-router-dom";
import HomePage from "./Pages/HomePage/HomePage.page";
import ProfilePage from "./Pages/ProfilePage/ProfilePage.page";
import HrProfiles from "./Pages/HrPage/hrPage.page";

// import './app.scss';

class App extends React.Component {
  render() {
    return (
      <div className="app">
        <NavBar />
        <Switch>
          <Route exact path="/" component={HomePage} />
          <Route path="/profiles" component={ProfilePage} />
          <Route path="/hrprofiles" component={HrProfiles} />
        </Switch>
      </div>
    );
  }
}

export default App;
