import React from "react";
import "./Profile.style.scss";
import Input from "./input.profile.comp";

class Profile extends React.Component {
  constructor() {
    super();

    this.state = {
      showProfile: false
    };
  }

  handle = (profileId, rowID, criteriaID, criteriaName, value) => {
    this.props.change(profileId, rowID, criteriaID, criteriaName, value);
  };

  showProfile = nameOfState => {
    this.setState({ [nameOfState]: !this.state[nameOfState] });
  };

  render() {
    const { id, name, position, all } = this.props;
    return (
      <div>
        <button onClick={() => this.showProfile("showProfile")}>{name}</button>
        {this.state.showProfile ? (
          <div>
            <h5>
              Name: {name} Position: {position}
            </h5>
            <table className="Profile">
              <tbody>
                <tr className="u-textCenter">
                  <th></th>
                  <th>Criteria</th>
                  <th>Self Evaluation</th>
                  <th>Comments</th>
                  <th>Team lead evaluation</th>
                  <th>Overall</th>
                </tr>
                {all.map(data => {
                  return (
                    <React.Fragment key={data.id}>
                      <tr>
                        <td rowSpan={data.list.length}>{data.name}</td>
                        <td>{data.list[0].criteria}</td>

                        <td>
                          <select
                            name="level"
                            defaultValue={data.list[0].selfEvaluation}
                            onChange={value =>
                              this.handle(
                                id,
                                data.id,
                                data.list[0].id,
                                "selfEvaluation",
                                value.target.value
                              )
                            }
                          >
                            <option value="Unfamiliar">Unfamiliar</option>
                            <option value="Familiar">Familiar</option>
                            <option value="Expert">Expert</option>
                          </select>
                        </td>

                        <Input
                          id={id}
                          rowId={data.id}
                          criteriaId={data.list[0].id}
                          criteriaName="comments"
                          change={this.handle}
                          name={data.list[0].comments}
                        />
                        <td>
                          <select
                            name="teamLeadEvaluation"
                            defaultValue={
                              data.list[0].teamLeadEvaluation ? "True" : "False"
                            }
                            onChange={value =>
                              this.handle(
                                id,
                                data.id,
                                data.list[0].id,
                                "teamLeadEvaluation",
                                value.target.value
                              )
                            }
                          >
                            <option value="True">True</option>
                            <option value="False">False</option>
                          </select>
                        </td>
                        {/* <td>{data.list[0].overall}</td>
                         */}
                        <Input
                          id={id}
                          rowId={data.id}
                          criteriaId={data.list[0].id}
                          criteriaName="overall"
                          change={this.handle}
                          name={data.list[0].overall}
                        />
                      </tr>
                      {data.list
                        .filter((check, i) => i !== 0)
                        .map(list => {
                          return (
                            <tr key={list.id}>
                              <td>{list.criteria}</td>

                              <td>
                                <select
                                  name="level"
                                  defaultValue={list.selfEvaluation}
                                  onChange={value =>
                                    this.handle(
                                      id,
                                      data.id,
                                      list.id,
                                      "selfEvaluation",
                                      value.target.value
                                    )
                                  }
                                >
                                  <option value="Unfamiliar">Unfamiliar</option>
                                  <option value="Familiar">Familiar</option>
                                  <option value="Expert">Expert</option>
                                </select>
                              </td>

                              <Input
                                id={id}
                                rowId={data.id}
                                criteriaId={list.id}
                                criteriaName="comments"
                                change={this.handle}
                                name={list.comments}
                              />
                              <td>
                                <select
                                  name="teamLeadEvaluation"
                                  defaultValue={
                                    list.teamLeadEvaluation ? "True" : "False"
                                  }
                                  onChange={value =>
                                    this.handle(
                                      id,
                                      data.id,
                                      list.id,
                                      "teamLeadEvaluation",
                                      value.target.value
                                    )
                                  }
                                >
                                  <option value="True">True</option>
                                  <option value="False">False</option>
                                </select>
                              </td>
                              {/* <td>{list.overall}</td> */}
                              <Input
                                id={id}
                                rowId={data.id}
                                criteriaId={list.id}
                                criteriaName="overall"
                                change={this.handle}
                                name={list.overall}
                              />
                            </tr>
                          );
                        })}
                    </React.Fragment>
                  );
                })}
              </tbody>
            </table>
          </div>
        ) : null}
      </div>
    );
  }
}

export default Profile;
