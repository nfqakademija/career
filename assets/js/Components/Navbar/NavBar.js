import React from "react";
import { Link } from "react-router-dom";
import "./NavBar.scss";
// import withRouter from 'react-router-dom';

class NavBar extends React.Component {
  constructor() {
    super();

    this.state = {
      route: null
    };
  }

  componentDidMount(){
    if(window.location.pathname !== '/'){
      this.setState({route: false})
    } else {this.setState({route: true})}
  }

  render() {
    return (
      <div>
        <nav
          className="navbar navbar-expand-lg navbar-dark"
          style={
            this.state.route
              ? { background: "transparent" }
              : { background: "rgb(237, 219, 187)" }
          }
        >
          <div className="d-flex flex-grow-1">
            <span className="w-100 d-lg-none d-block"></span>
            <Link
              className="navbar-brand"
              to="/"
              onClick={() => this.setState({ route: true })}
            >
              <span className="my-color-logo">CCA</span>
            </Link>
            <div className="w-100 text-right">
              <button
                className="navbar-toggler"
                type="button"
                data-toggle="collapse"
                data-target="#myNavbar7"
              >
                <span className="navbar-toggler-icon"></span>
              </button>
            </div>
          </div>
          <div
            className="collapse navbar-collapse flex-grow-1 text-right"
            id="myNavbar7"
          >
            <ul className="navbar-nav ml-auto flex-nowrap">
              <li
                className="nav-item"
                onClick={() => this.setState({ route: true })}
              >
                <Link className="nav-link" to="/">
                  <span className="my-color">Home</span>
                </Link>
              </li>
              <li
                className="nav-item"
                onClick={() => this.setState({ route: false })}
              >
                <Link className="nav-link" to="/profiles">
                  <span className="my-color">Profiles</span>
                </Link>
              </li>
              <li
                className="nav-item"
                onClick={() => this.setState({ route: false })}
              >
                <Link className="nav-link" to="/hrprofiles">
                  <span className="my-color">HR Page</span>
                </Link>
              </li>
            </ul>
          </div>
        </nav>
      </div>
    );
  }
}

export default NavBar;
