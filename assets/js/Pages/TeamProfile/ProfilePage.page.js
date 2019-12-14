import React from "react";
import Axios from "axios";
import { connect } from "react-redux";
import "./ProfilePage.style.scss";
import ProfileButtons from "../../Components/ProfileButtons/ProfileButtons.comp";
import CompetenceView from "../../Components/CompetenceView/competenceView.comp";
import { restartAnswersTeamLeadSide, restartAnswers } from "../../Actions/action";
import { getUserAnswer } from "../../thunk/getUserAnswer";
import { getTeamLeadAnswer } from "../../thunk/getTeamLeadAnswer";

class ProfilePage extends React.Component {
  constructor() {
    super();

    this.state = {
      profileNames: [],
      fullProfile: [],
      userFormId: null
    };
  }
  componentDidMount() {
    Axios.get(`/api/teams/${this.props.teams[0].id}/users`)
      .then(res => {
        console.log(res.data.list);
        this.setState({ profileNames: res.data.list });
      })
      .catch(err => console.log(err));
  }

  selectedUser = id => {
    Axios.get(`/api/forms/${id}`)
      .then(res => {
        this.setState({ fullProfile: res.data });
        this.props.onGetUserAnswer(res.data.id);
        // this.props.onGetTeamLeadAnswer(...)
        this.setState({userFormId: res.data.id})
      })
      .catch(err => {
        console.log(err);
        this.setState({ fullProfile: null });
      });
  };

  submit = () => {
    let obj = {
      formId: this.state.userFormId,
      choiceAnswers: this.props.answers,
      commentAnswers: this.props.comments
    };
    console.log(obj);
    console.log("THis is teamLead page Submit")
    if (this.props.answers.length === 0 && this.props.comments.length === 0) {
      alert("You haven't changed anything.");
    } else {
      Axios.post("/api/feedback", {
        data: obj
      })
        .then(function(response) {
          alert("Created successfully");
        })
        .catch(function(error) {
          console.log(error);
          alert("Something went wrong... Try again later");
        });
      this.props.onRestartAnswers();
    }
  };

  render() {
    return (
      <div className="profilePage">
        {this.state.profileNames.map(profileNames => (
          <ProfileButtons
            key={profileNames.id}
            id={profileNames.id}
            name={profileNames.firstName + " " + profileNames.lastName}
            handle={this.selectedUser}
          />
        ))}
        <div>
          {this.state.fullProfile.length === 0 ? (
            this.state.fullProfile === null ? (
              <h1>No data about this profile yet.</h1>
            ) : null
          ) : (
            <React.Fragment>
              <CompetenceView
                name={this.state.fullProfile.userView.firstName}
                position={this.state.fullProfile.profile.professionTitle}
                competence={this.state.fullProfile.profile.criteriaList}
                submit={this.submit}
              />
            </React.Fragment>
          )}
        </div>
      </div>
    );
  }
}

const mapStateToProps = state => ({
  teams: state.user.teams,
  answers: state.trackUserChanges.choiceAnswers,
  comments: state.trackUserChanges.comment
});

const mapDispatchToProps = dispatch => ({
  onRestartAnswersTeamLeadSide: () => dispatch(restartAnswersTeamLeadSide()),
  onRestartAnswers: () => dispatch(restartAnswers()),
  onGetUserAnswer: formId => dispatch(getUserAnswer(formId))
  // onGetTeamLeadAnswer: formId => dispatch(getTeamLeadAnswer(formId))
});

export default connect(mapStateToProps, mapDispatchToProps)(ProfilePage);
