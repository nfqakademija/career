import React from "react";
import {
  setComment,
  updateCommentAnswerTeamLeadSide,
  isActionCalled
} from "../../Actions/action";
import { connect } from "react-redux";
import { checkForAnswerId } from "../../helpers/helpers";

class Comments extends React.Component {
  constructor() {
    super();

    this.state = {
      changeComment: false,
      inputValue: "No comments"
    };
  }

  componentDidMount() {
    const checkForAnswer = this.checkForAnswer();
    checkForAnswer === null
      ? null
      : this.setState({ inputValue: checkForAnswer });
  }

  checkForAnswer = () => {
    for (let i = 0; i < this.props.choiceList.length; i++) {
      if (
        this.props.choiceList[i].criteriaId === this.props.criteriaId &&
        this.props.choiceList[i].comment !== null &&
          this.props.choiceList[i].comment !== undefined
      ) {
        return this.props.choiceList[i].comment;
      }
    }
    return null;
  };

  handle = () => {
    this.setState({ changeComment: !this.state.changeComment });

    let answerId = checkForAnswerId(
      this.props.choicesFromUser,
      this.props.criteriaId
    );

    //we track changes of comment
    this.props.onSetComment(
      this.props.criteriaId,
      this.state.inputValue,
      answerId
    );

    //we update list of answers in return our changes wont disapear until website refresh
    this.props.onUpdateCommentAnswer(
      this.props.criteriaId,
      this.state.inputValue
    );

    this.props.onSetChangedValues(true);
  };

  render() {
    if (!this.props.managerPage) {
      let answer = "Not answered";
      const check = this.checkForAnswer();
      check === null ? null : (answer = check);
      return (
        <div className="comment-Box">
          <span className="comment">{answer}</span>
        </div>
      );
    }

    return (
      <div>
        {this.state.changeComment ? (
          <React.Fragment>
            <input
              type="text"
              placeholder={this.state.inputValue}
              onChange={value =>
                this.setState({ inputValue: value.target.value })
              }
            />
            <button onClick={this.handle}>Save</button>
          </React.Fragment>
        ) : (
          <React.Fragment>
            <div className="comment-Box">
              <span className="comment">{this.state.inputValue}</span>
              <button
                className="commentButton"
                onClick={() =>
                  this.setState({ changeComment: !this.state.changeComment })
                }
              >
                Change
              </button>
            </div>
          </React.Fragment>
        )}
      </div>
    );
  }
}

const mapStateToProps = state => ({
  choiceList: state.answerListTeamLeadSide.choiceList,
  choicesFromUser: state.answerListUserSide.choiceList,
  managerPage: state.managerPage.selected
});

const mapDispatchToProps = dispatch => ({
  onSetComment: (criteriaId, comment, answerId) =>
    dispatch(setComment(criteriaId, comment, answerId)),
  onUpdateCommentAnswer: (criteriaId, comment) =>
    dispatch(updateCommentAnswerTeamLeadSide(criteriaId, comment)),
  onSetChangedValues: bollean => dispatch(isActionCalled(bollean))
});

export default connect(mapStateToProps, mapDispatchToProps)(Comments);
