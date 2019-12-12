import React from "react";
import { Link } from "react-router-dom";
import "./NavBar.scss";
import logo from "../../../pics/logo6.png";
import { withRouter } from "react-router";
import { connect } from "react-redux";
import { setLogged, resetApp } from "../../Actions/action";

class NavBar extends React.Component {
  constructor(props) {
    super(props);

    this.state = {
      route: props.location.pathname,
      width: "80%"
    };
  }

  listenScrollEvent = e => {
    if (window.scrollY > 100) {
      this.setState({ width: "100%" });
    } else {
      this.setState({ width: "80%" });
    }
  };

  componentDidMount() {
    if (this.props.location.pathname === "/") {
      this.setState({ route: "/" });
    } else {
      this.setState({ route: false });
    }

    window.addEventListener("scroll", this.listenScrollEvent);
  }

  componentDidUpdate(prevProps) {
    if (
      this.props.location.pathname === "/" &&
      prevProps.location.pathname !== "/"
    ) {
      this.setState({ route: "/" });
    }

    if (
      this.props.location.pathname !== "/" &&
      prevProps.location.pathname === "/"
    ) {
      this.setState({ route: "false" });
    }
  }

  logout = () => {
    this.props.onSetLogged(!this.props.logged);
    this.props.onResetApp();
  }

  render() {
    return (
      <div className="navigation">
        <nav
          className="navbar navbar-expand-lg navbar-dark"
          style={
            this.state.route === "/"
              ? { background: "rgb(224, 107, 18)", width: this.state.width }
              : {
                  background: "rgb(209, 209, 209)",
                  borderColor: "white",
                  color:"black",
                  width: "100%"
                }
          }
          // onScroll={{width: "100%"}}
        >
          <div className="d-flex flex-grow-1">
            <span className="w-100 d-lg-none d-block"></span>
            <Link className="navbar-brand" to="/">
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
              <li className="nav-item">
                <Link className="nav-link" to="/">
                  <span className="my-color">Home</span>
                </Link>
              </li>
              {this.props.logged ? null : (
                <li className="nav-item">
                  <Link className="nav-link" to="/login">
                    <span className="my-color">Login</span>
                  </Link>
                </li>
              )}

              {this.props.logged ? (
                <li className="nav-item">
                  <Link className="nav-link" to="/user">
                    <span className="my-color">My Profile</span>
                  </Link>
                </li>
              ) : null}
              {this.props.roles.includes("ROLE_HEAD") &&
              this.props.logged === true ? (
                <li className="nav-item">
                  <Link className="nav-link" to="/profiles">
                    <span className="my-color">Team Profiles</span>
                  </Link>
                </li>
              ) : null}
              {this.props.roles.includes("ROLE_ADMIN") &&
              this.props.logged === true ? (
                <li className="nav-item">
                  <Link className="nav-link" to="/hrprofiles">
                    <span className="my-color">Create Profiles</span>
                  </Link>
                </li>
              ) : null}
              {this.props.logged ? (
                <li className="nav-item">
                  <div className="nav-link">
                    <span className="my-color">
                      Logged as: {this.props.email}
                    </span>
                  </div>
                </li>
              ) : null}
              {this.props.logged ? (
                <li className="nav-item">
                  <div
                    className="nav-link"
                    onClick={this.logout}
                  >
                    <span className="logout my-color">Logout</span>
                  </div>
                </li>
              ) : null}
            </ul>
          </div>
        </nav>
      </div>
    );
  }
}

const mapStateToProps = state => ({
  roles: state.user.roles,
  email: state.user.email,
  logged: state.user.logged
});

const mapDispatchToProps = dispatch => ({
  onSetLogged: logged => dispatch(setLogged(logged)),
  onResetApp: () => dispatch(resetApp())
});

export default connect(mapStateToProps, mapDispatchToProps)(withRouter(NavBar));
