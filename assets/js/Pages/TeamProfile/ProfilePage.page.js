import React from "react";
import Axios from "axios";
import { connect } from "react-redux";
import "./ProfilePage.style.scss";
import ProfileButtons from "../../Components/ProfileButtons/ProfileButtons.comp";
import CompetenceView from "../../Components/CompetenceView/competenceView.comp";
import {
  restartAnswersTeamLeadSide,
  restartAnswers
} from "../../Actions/action";
import { getUserAnswer } from "../../thunk/getUserAnswer";
import { getTeamLeadAnswer } from "../../thunk/getTeamLeadAnswer";
import { submitAnswers } from "../../thunk/submitAnswers";

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
        const formId = res.data.id;
        this.setState({ fullProfile: res.data });
        this.props.onGetUserAnswer(formId);
        this.props.onGetTeamLeadAnswer(formId);
        this.setState({ userFormId: formId });
      })
      .catch(err => {
        console.log(err);
        this.setState({ fullProfile: null });
      });
  };

  submit = () => {
    this.props.onSubmitAnswers(
      "/api/feedback",
      this.state.userFormId,
      this.props.answers,
      this.props.comments
    );
  };

  render() {
    return (
      <div className="profilePage">
        <div className="teamUsers">
          {this.state.profileNames.map(profileNames => (
            <ProfileButtons
              key={profileNames.id}
              id={profileNames.id}
              name={profileNames.firstName + " " + profileNames.lastName}
              handle={this.selectedUser}
            />
          ))}
        </div>

        <div>
          {this.state.fullProfile.length === 0 ? (
            this.state.fullProfile === null ? (
              <h1>No data about this profile yet.</h1>
            ) : null
          ) : (
            <React.Fragment>
              <CompetenceView
                name={
                  this.state.fullProfile.userView.firstName +
                  " " +
                  this.state.fullProfile.userView.lastName
                }
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
  onGetUserAnswer: formId => dispatch(getUserAnswer(formId)),
  onGetTeamLeadAnswer: formId => dispatch(getTeamLeadAnswer(formId)),
  onSubmitAnswers: (api, formId, answers, comments) =>
    dispatch(submitAnswers(api, formId, answers, comments))
});

export default connect(mapStateToProps, mapDispatchToProps)(ProfilePage);
