async function loadResults() {

    const res = await fetch("../backend/voting/results.php")

    const data = await res.json()

    const names = []
    const votes = []

    data.forEach(c => {
        names.push(c.name)
        votes.push(Number(c.votes))
    })

    const ctx = document.getElementById("chart").getContext("2d")

    new Chart(ctx, {
        type: "bar",

        data: {
            labels: names,
            datasets: [{
                label: "Votes",
                data: votes,
                backgroundColor: "#4e73df"
            }]
        },

        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }

    })

}

function logout() {
    window.location = "login.html"
}

loadResults()