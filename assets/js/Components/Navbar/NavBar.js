import React from "react";
import { Link } from "react-router-dom";
import "./NavBar.scss";

const NavBar = () => {
  return (
    <div>
      <nav className="navbar navbar-expand-lg navbar-dark">
        <div className="d-flex flex-grow-1">
          <span className="w-100 d-lg-none d-block"></span>
          <Link className="navbar-brand" to="/">
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
            <li className="nav-item">
              <Link className="nav-link" to="/">
                <span className="my-color">Hoooome</span>
              </Link>
            </li>
            <li className="nav-item">
              <Link className="nav-link" to="/profiles">
              <span className="my-color">Profiles</span>
              </Link>
            </li>
            <li className="nav-item">
              <Link className="nav-link" to="/hrprofiles">
              <span className="my-color">HR Profiles</span>
              </Link>
            </li>
            {/* <li class="nav-item">
              <a href="#" class="nav-link">
                Link
              </a>
            </li> */}
          </ul>
        </div>
      </nav>
    </div>
  );
};

export default NavBar;
