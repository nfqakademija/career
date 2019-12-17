import React from "react";
import { connect } from "react-redux";
import {
  setAnswers,
  updateChoiceAnswerTeamLeadSide,
  isActionCalled
} from "../../Actions/action";
import { checkForAnswerId } from "../../helpers/helpers";

class ChoiceListTeamLead extends React.Component {
  onSelect = event => {
    const selectedIndex = event.target.options.selectedIndex;
    const choiceValue = event.target.options[selectedIndex].getAttribute(
      "data-value"
    );
    const convertedToBollean = choiceValue === "true" ? true : false;

    let answerId = checkForAnswerId(
      this.props.choicesFromUser,
      this.props.criteriaId
    );

    this.props.onSetAnswers(
      this.props.criteriaId,
      convertedToBollean,
      answerId
    );
    this.props.onUpdateChoiceTeamLeadAnswer(
      this.props.criteriaId,
      convertedToBollean
    );
    this.props.onSetChangedValues(true);
  };

  render() {
    let answer = "NoAnswer";
    for (let i = 0; i < this.props.choiceList.length; i++) {
      if (
        this.props.choiceList[i].criteriaId === this.props.criteriaId &&
        (this.props.choiceList[i].evaluation === true ||
          this.props.choiceList[i].evaluation === false)
      ) {
        this.props.choiceList[i].evaluation === true
          ? (answer = "True")
          : (answer = "False");
      }
    }

    if (!this.props.managerPage) {
      return <div>{answer}</div>;
    }

    return (
      <select
        className="choiceListSelect"
        defaultValue={answer}
        onChange={this.onSelect}
      >
        {answer === "NoAnswer" ? (
          <option value={"NoAnswer"} data-value={"Not answered"}>
            --Not answered--
          </option>
        ) : null}
        <option value={"False"} data-value={false}>
          False
        </option>
        <option value={"True"} data-value={true}>
          True
        </option>
        ))}
      </select>
    );
  }
}

const mapStateToProps = state => ({
  choiceList: state.answerListTeamLeadSide.choiceList,
  choicesFromUser: state.answerListUserSide.choiceList,
  managerPage: state.managerPage.selected
});

const mapDispatchToProps = dispatch => ({
  onSetAnswers: (criteriaId, choiceId, answerId) =>
    dispatch(setAnswers(criteriaId, choiceId, answerId)),
  onUpdateChoiceTeamLeadAnswer: (criteriaId, choiceId) =>
    dispatch(updateChoiceAnswerTeamLeadSide(criteriaId, choiceId)),
  onSetChangedValues: bollean => dispatch(isActionCalled(bollean))
});

export default connect(mapStateToProps, mapDispatchToProps)(ChoiceListTeamLead);
