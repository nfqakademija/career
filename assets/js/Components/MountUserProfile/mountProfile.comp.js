import React from "react";
import { connect } from "react-redux";
import "./mountProfile.style.scss";
import Axios from "axios";
import { setChoiceList, restartAnswers } from "../../Actions/action";
import CompetenceView from "../CompetenceView/competenceView.comp";

class MountProfile extends React.Component {
  componentDidMount() {
    Axios.get(`/api/answers/${this.props.formId}`)
      .then(res => {
        if (res.data === 404) {
          this.props.onRestartAnswers();
        } else {
          const data = res.data;
          this.props.onSetChoiceList(data.list);
        }
      })
      .catch(err => console.log(err));
  }

  submit = () => {
    let obj = {
      formId: this.props.formId,
      choiceAnswers: this.props.answers,
      commentAnswers: this.props.comments
    };
    console.log(obj)

    if (this.props.answers.length === 0 && this.props.comments.length === 0) {
      alert("You haven't changed anything.");
    } else {
      Axios.post("/api/answers", {
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
      <div className="mountProfile">
        <CompetenceView
          name={this.props.name}
          position={this.props.data.profile.professionTitle}
          competence={this.props.data.profile.criteriaList}
          submit={this.submit}
        />
      </div>
    );
  }
}

const mapStateToProps = state => ({
  userId: state.user.userId,
  name: state.user.name,
  formId: state.user.formId,
  answers: state.trackUserChanges.choiceAnswers,
  comments: state.trackUserChanges.comment
});

const mapDispatchToProps = dispatch => ({
  onSetChoiceList: choiceList => dispatch(setChoiceList(choiceList)),
  onRestartAnswers: () => dispatch(restartAnswers())
});

export default connect(mapStateToProps, mapDispatchToProps)(MountProfile);
