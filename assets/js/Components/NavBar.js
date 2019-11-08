import React from "react";
import "../../css/NavBar.scss";

const NavBar = () => {
  return (
    <nav className="navbar navbar-expand-lg navbar-light bg-light">
      <a className="navbar-brand navLogo" href="#">
        CCA
      </a>
      <button
        className="navbar-toggler"
        type="button"
        data-toggle="collapse"
        data-target="#navbarNav"
        aria-controls="navbarNav"
        aria-expanded="false"
        aria-label="Toggle navigation"
      >
        <span className="navbar-toggler-icon"></span>
      </button>
      <div className="collapse navbar-collapse" id="navbarNav">
        <ul className="navbar-nav">
          <li className="nav-item u-padding0x30 active">
            <a className="nav-link" href="#">
              Home<span className="sr-only">(current)</span>
            </a>
          </li>
          {/* <li className="nav-item u-padding0x30">
                        <a className="nav-link" href="#">Features</a>
                    </li>
                    <li className="nav-item u-padding0x30">
                        <a className="nav-link" href="#">Pricing</a>
                    </li> */}
          {/* <li class="nav-item">
                        <a class="nav-link disabled" href="#" tabindex="-1" aria-disabled="true">Disabled</a>
                    </li> */}
        </ul>
      </div>
    </nav>
  );
};

export default NavBar;
