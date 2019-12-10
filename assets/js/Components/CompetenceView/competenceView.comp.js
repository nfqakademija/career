import React from "react";
import Profile from '../Profile.v2/profile.comp';

class CompetenceView extends React.Component {
  constructor() {
    super();

    this.state = {
      showProfile: []
    };
  }

  toogle = i => {
    if (this.state.showProfile.includes(i)) {
      const array = [...this.state.showProfile];
      const index = array.indexOf(i);
      array.splice(index, 1);
      this.setState({ showProfile: array });
    } else {
      this.setState({ showProfile: this.state.showProfile.concat(i) });
    }
  };

  render() {
    const { name, position, competence, submit } = this.props;
    return (
      <div className="mountProfile">
        <div className="u-flexCenter">
          <h4>Name: {name}</h4>
          <h4>Position: {position}</h4>
        </div>

        <div className="profile">
          <h4 className="careerProfile">Competences:</h4>
          {competence.map((data, index) => {
            return (
              <React.Fragment key={index}>
                <div className="competence">
                  <h4
                    onClick={() => this.toogle(index)}
                    style={
                      this.state.showProfile.includes(index)
                        ? {
                            borderBottom: "none",
                            borderRadius: "30px 30px 0px 0px"
                          }
                        : { borderRadius: "30px 30px 30px 30px" }
                    }
                  >
                    {data.competence}
                  </h4>
                  {this.state.showProfile.includes(index) ? (
                    <Profile criteriaList={data.criteria} />
                  ) : null}
                </div>
              </React.Fragment>
            );
          })}
          <button className="submitButton" onClick={submit}>
            Save
          </button>
        </div>
      </div>
    );
  }
}

export default CompetenceView;
