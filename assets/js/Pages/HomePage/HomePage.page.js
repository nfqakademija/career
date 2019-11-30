import React from "react";
import "./HomePage.style.scss";
import picture from "../../../pics/office2.png";
import { Link } from "react-router-dom";

class HomePage extends React.Component {
  render() {
    return (
      <div className="homePage">
        <div className="content">
          <div className="u-flexCenter">
            <h1>Career Criteria Assessment</h1>
            <br />
            <Link to="login">
              <button>Login</button>
            </Link>
          </div>
          <img src={picture} />
        </div>
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320">
          <path
            fill="#e06b12"
            fillOpacity="1"
            d="M0,160L80,133.3C160,107,320,53,480,58.7C640,64,800,128,960,138.7C1120,149,1280,107,1360,85.3L1440,64L1440,0L1360,0C1280,0,1120,0,960,0C800,0,640,0,480,0C320,0,160,0,80,0L0,0Z"
          ></path>
        </svg>
      </div>
    );
  }
}

export default HomePage;
