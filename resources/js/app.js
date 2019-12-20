require('./bootstrap');

var viz;

function draw() {
    var config = {
        container_id: "viz",
        server_url: `bolt://${process.env.MIX_NEO4J_HOST}:${process.env.MIX_NEO4J_POST}`,
        server_user: process.env.MIX_NEO4J_USERNAME,
        server_password: process.env.MIX_NEO4J_PASSWORD,
        labels: {
            "School": {
                "caption": "name"
            },
            "Student": {
                "caption": "name"
            },
            "Project": {
                "caption": "name"
            },
            "Reading": {
                "caption": "name"
            },
        },
        relationships: {
            "HAS": {
                "thickness": "weight",
                "caption": true
            },
            "MEMBER_OF": {
                "thickness": "weight",
                "caption": true
            },
            "READING": {
                "thickness": "weight",
                "caption": true
            },
        },
        initial_cypher: "MATCH (n)-[r]->(m) RETURN n"
    };

    viz = new NeoVis.default(config);
    viz.render();
}

document.getElementById('viz') ? window.onload = draw : "";
