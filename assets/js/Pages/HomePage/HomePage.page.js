import React from "react";
import LogIn from "../../Components/LogIn/ValidatedLoginForm";
import "./HomePage.style.scss";

class HomePage extends React.Component {
  render() {
    return (
      <div>
        {/* <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320">
          <path
            fill="#086a75"
            fillOpacity="1"
            d="M0,128L40,112C80,96,160,64,240,69.3C320,75,400,117,480,117.3C560,117,640,75,720,64C800,53,880,75,960,74.7C1040,75,1120,53,1200,74.7C1280,96,1360,160,1400,192L1440,224L1440,320L1400,320C1360,320,1280,320,1200,320C1120,320,1040,320,960,320C880,320,800,320,720,320C640,320,560,320,480,320C400,320,320,320,240,320C160,320,80,320,40,320L0,320Z"
          ></path>
        </svg> */}
        <div className="homePage">
          <LogIn />
        </div>
        <div>
          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320">
            <path
              fill="#086a75"
              fillOpacity="1"
              d="M0,128L48,122.7C96,117,192,107,288,128C384,149,480,203,576,202.7C672,203,768,149,864,149.3C960,149,1056,203,1152,218.7C1248,235,1344,213,1392,202.7L1440,192L1440,0L1392,0C1344,0,1248,0,1152,0C1056,0,960,0,864,0C768,0,672,0,576,0C480,0,384,0,288,0C192,0,96,0,48,0L0,0Z"
            ></path>
          </svg>
        </div>
      </div>
    );
  }
}

export default HomePage;
