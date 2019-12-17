import React from "react";
import "./HomePage.style.scss";
import picture from "../../../pics/office2.png";
import pictureProblem from "../../../pics/problemv3.jpg";
import pictureIdea from "../../../pics/idea.jpg";
import pictureSolution from "../../../pics/solution.jpg";
import { Link } from "react-router-dom";
import { connect } from "react-redux";

class HomePage extends React.Component {
  render() {
    return (
      <div className="homePage">
        <header>
          <div className="u-flexCenter">
            <h1>Career Criteria Assessment</h1>
            <p>Solution for companies to manage employees career profiles.</p>
            <br />
            {this.props.logged ? (
              <h5>Welcome, {this.props.name}</h5>
            ) : (
                <Link to="login">
                  <button>Login</button>
                </Link>
              )}
          </div>
          <img src={picture} />
        </header>

        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 160">
          <path
            fill="#e06b12"
            fillOpacity="1"
            d="M0,160L80,133.3C160,107,320,53,480,58.7C640,64,800,128,960,138.7C1120,149,1280,107,1360,85.3L1440,64L1440,0L1360,0C1280,0,1120,0,960,0C800,0,640,0,480,0C320,0,160,0,80,0L0,0Z"
          ></path>
        </svg>

        <h1 className="contentHeader">More About Us</h1>

        <div className="content">
          <div className="content-Box">
            <img src={pictureProblem} />
            <div className="content-Box-width">
              <h1 className="u-textCenter">Problem</h1>
              <p>
                It's difficult to track all employees skills, measure skill
                level and assign employees to specific task without keeping an
                eye on their improvement and current skills.
              </p>
            </div>
          </div>
          <div className="content-Box u-reverseRow">
            <img src={pictureIdea} />
            <div className="content-Box-width">
              <h1 className="u-textCenter">Idea</h1>
              <p>
                Our objective is to make these things as simple as possible!
              </p>
            </div>
          </div>
          <div className="content-Box">
            <img src={pictureSolution} />
            <div className="content-Box-width">
              <h1 className="u-textCenter">Solution</h1>
              <p>
                We offer you a system where every employee can see his personal
                profile and measure his skill level in different criterias. Team
                leader will review employees submissions and approve them.
                Simple as that!
              </p>
            </div>
          </div>
        </div>
      </div>
    );
  }
}

const mapStateToProps = state => ({
  logged: state.user.logged,
  name: state.user.name
});

export default connect(mapStateToProps, null)(HomePage);
