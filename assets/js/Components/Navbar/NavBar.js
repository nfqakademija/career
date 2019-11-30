import React from "react";
import { Link } from "react-router-dom";
import "./NavBar.scss";
import logo from "../../../pics/logo6.png";
import { withRouter } from "react-router";


class NavBar extends React.Component {
  constructor(props) {
    super(props);

    this.state = {
      route: props.location.pathname
    };
  }

  componentDidMount() {
    if (this.props.location.pathname === "/") {
      this.setState({ route: '/' });
    } else {
      this.setState({ route: false });
    }
  }

  componentDidUpdate(prevProps){
    if(this.props.location.pathname === '/' && prevProps.location.pathname !== '/'){
      this.setState({route: '/'})
    }

    if(this.props.location.pathname !== '/' && prevProps.location.pathname === '/'){
      this.setState({route: 'false'})
    }
  }

  render() {
    return (
      <div
        className="navigation">
        <nav
          className="navbar navbar-expand-lg navbar-dark"
          style={
            this.state.route === '/'
              ? { background: "rgb(224, 107, 18)" }
              : {
                  background: "rgb(237, 219, 187)",
                  border: "none",
                  width: "100%"
                }
          }
        >
          <div className="d-flex flex-grow-1">
            <span className="w-100 d-lg-none d-block"></span>
            <Link
              className="navbar-brand"
              to="/"
            >
              <img src={logo} className="my-logo" />
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
              >
                <Link className="nav-link" to="/">
                  <span className="my-color">Home</span>
                </Link>
              </li>
              <li
                className="nav-item"
              >
                <Link className="nav-link" to="/profiles">
                  <span className="my-color">Profiles</span>
                </Link>
              </li>
              <li
                className="nav-item"
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

export default withRouter(NavBar);
